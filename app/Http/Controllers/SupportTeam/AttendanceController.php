<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\MyClass;
use App\Models\Section;
use App\Models\StudentAttendance;
use App\Models\StudentRecord;
use App\Repositories\MyClassRepo;
use App\Services\AttendanceService;
use App\Services\BikramSambatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected $attendanceService;
    protected $bsService;
    protected $myClassRepo;

    public function __construct(
        AttendanceService $attendanceService,
        BikramSambatService $bsService,
        MyClassRepo $myClassRepo
    ) {
        $this->attendanceService = $attendanceService;
        $this->bsService = $bsService;
        $this->myClassRepo = $myClassRepo;
    }

    /**
     * Daily student attendance entry & view.
     */
    public function index(Request $request)
    {
        $data['my_classes'] = $this->myClassRepo->all();
        $data['academic_years'] = AcademicYear::orderBy('year_bs', 'desc')->get();
        $todayBs = $this->bsService->adToBs(date('Y-m-d'))['bs_date'];

        $classId = $request->get('my_class_id');
        $sectionId = $request->get('section_id');
        $bsDate = $request->get('attendance_date_bs', $todayBs);

        $data['selected_class'] = $classId;
        $data['selected_section'] = $sectionId;
        $data['selected_date'] = $bsDate;
        $data['today_bs'] = $todayBs;
        $data['sections'] = $classId ? Section::where('my_class_id', $classId)->get() : collect();
        $data['students'] = collect();
        $data['existing_records'] = collect();
        $data['is_already_recorded'] = false;
        $data['date_info'] = null;
        $data['can_manage'] = true;

        if ($classId) {
            $user = Auth::user();
            $data['can_manage'] = $this->attendanceService->canUserManageAttendance($user, $classId, $sectionId);

            try {
                $data['date_info'] = $this->attendanceService->inspectAttendanceDate($bsDate);
                $adDate = $data['date_info']['ad_date'];

                $studentsQuery = StudentRecord::where('my_class_id', $classId);
                if ($sectionId) {
                    $studentsQuery->where('section_id', $sectionId);
                }
                $data['students'] = $studentsQuery->with('user')->get();

                $attendances = StudentAttendance::where('my_class_id', $classId)
                    ->when($sectionId, function ($q) use ($sectionId) {
                        return $q->where('section_id', $sectionId);
                    })
                    ->where('attendance_date', $adDate)
                    ->get()
                    ->keyBy('student_record_id');

                $data['existing_records'] = $attendances;
                $data['is_already_recorded'] = ($attendances->count() > 0);
            } catch (\Exception $e) {
                return back()->with('flash_danger', __('Invalid BS date: ') . $e->getMessage());
            }
        }

        return view('pages.support_team.attendance.index', $data);
    }

    /**
     * Store or bulk update student attendance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'my_class_id' => 'required|exists:my_classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'attendance_date_bs' => 'required|string',
            'students' => 'required|array',
        ]);

        $user = Auth::user();
        $classId = $request->my_class_id;
        $sectionId = $request->section_id;

        if (!$this->attendanceService->canUserManageAttendance($user, $classId, $sectionId)) {
            abort(403, __('Unauthorized: You are not assigned to record attendance for this class or section.'));
        }

        try {
            $currentSession = Qs::getCurrentSession();
            $activeYear = AcademicYear::active()->first();

            $result = $this->attendanceService->recordStudentAttendance([
                'my_class_id' => $classId,
                'section_id' => $sectionId,
                'attendance_date_bs' => $request->attendance_date_bs,
                'session' => $currentSession,
                'academic_year_id' => $activeYear ? $activeYear->id : null,
                'students' => $request->students,
            ], $user, $request->ip());

            $msg = __('Attendance saved successfully. (:created new, :updated updated).', [
                'created' => $result['created'],
                'updated' => $result['updated'],
            ]);

            return redirect()->route('attendance.index', [
                'my_class_id' => $classId,
                'section_id' => $sectionId,
                'attendance_date_bs' => $request->attendance_date_bs,
            ])->with('flash_success', $msg);
        } catch (\Exception $e) {
            return back()->with('flash_danger', __('Failed to record attendance: ') . $e->getMessage());
        }
    }

    /**
     * View individual student attendance history.
     */
    public function studentHistory(Request $request, $student_id)
    {
        $sr = StudentRecord::with(['user', 'my_class', 'section'])->findOrFail($student_id);

        if (!$this->attendanceService->canUserViewStudentAttendance(Auth::user(), $sr->id)) {
            abort(403, __('Access Denied: You do not have permission to view this student\'s attendance.'));
        }

        $query = StudentAttendance::where('student_record_id', $sr->id);

        // Optional status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Optional date range
        if ($request->filled('start_date_bs')) {
            try {
                $startAd = $this->bsService->bsToAd($request->start_date_bs)['ad_date'];
                $query->where('attendance_date', '>=', $startAd);
            } catch (\Exception $e) {}
        }
        if ($request->filled('end_date_bs')) {
            try {
                $endAd = $this->bsService->bsToAd($request->end_date_bs)['ad_date'];
                $query->where('attendance_date', '<=', $endAd);
            } catch (\Exception $e) {}
        }

        $records = $query->orderBy('attendance_date', 'desc')->get();
        $stats = $this->attendanceService->computeAttendanceStats($records);

        $data['sr'] = $sr;
        $data['records'] = $records;
        $data['stats'] = $stats;
        $data['status_filter'] = $request->status;
        $data['start_date_bs'] = $request->start_date_bs;
        $data['end_date_bs'] = $request->end_date_bs;

        return view('pages.support_team.attendance.student_history', $data);
    }

    /**
     * Monthly attendance matrix for class/section.
     */
    public function monthly(Request $request)
    {
        $data['my_classes'] = $this->myClassRepo->all();
        $todayBs = $this->bsService->adToBs(date('Y-m-d'));
        $curYear = $todayBs['year'];
        $curMonth = $todayBs['month'];

        $classId = $request->get('my_class_id');
        $sectionId = $request->get('section_id');
        $yearBs = (int)$request->get('year_bs', $curYear);
        $monthBs = (int)$request->get('month_bs', $curMonth);

        $data['selected_class'] = $classId;
        $data['selected_section'] = $sectionId;
        $data['selected_year'] = $yearBs;
        $data['selected_month'] = $monthBs;
        $data['sections'] = $classId ? Section::where('my_class_id', $classId)->get() : collect();
        $data['matrix_data'] = null;

        if ($classId) {
            $data['matrix_data'] = $this->attendanceService->getMonthlyClassAttendanceMatrix(
                $classId,
                $sectionId,
                $yearBs,
                $monthBs
            );
        }

        return view('pages.support_team.attendance.monthly', $data);
    }

    /**
     * Class-wise daily attendance comparison report.
     */
    public function classReport(Request $request)
    {
        $todayBs = $this->bsService->adToBs(date('Y-m-d'))['bs_date'];
        $bsDate = $request->get('attendance_date_bs', $todayBs);
        $data['selected_date'] = $bsDate;
        $data['classes_report'] = [];

        try {
            $dateInfo = $this->attendanceService->inspectAttendanceDate($bsDate);
            $adDate = $dateInfo['ad_date'];
            $data['date_info'] = $dateInfo;

            $classes = MyClass::with('sections')->get();
            foreach ($classes as $c) {
                $studentsCount = StudentRecord::where('my_class_id', $c->id)->count();
                $attendances = StudentAttendance::where('my_class_id', $c->id)
                    ->where('attendance_date', $adDate)
                    ->get();

                $present = $attendances->where('status', 'present')->count();
                $late = $attendances->where('status', 'late')->count();
                $leave = $attendances->where('status', 'leave')->count();
                $absent = $attendances->where('status', 'absent')->count();
                $halfDay = $attendances->where('status', 'half_day')->count();
                $recorded = $attendances->count();

                $effectivePresent = $present + $late + ($halfDay * 0.5);
                $pct = $recorded > 0 ? round(($effectivePresent / $recorded) * 100, 1) : 0.0;

                $data['classes_report'][] = [
                    'class' => $c,
                    'total_students' => $studentsCount,
                    'recorded_attendance' => $recorded,
                    'present' => $present,
                    'late' => $late,
                    'leave' => $leave,
                    'absent' => $absent,
                    'percentage' => $pct,
                ];
            }
        } catch (\Exception $e) {
            return back()->with('flash_danger', __('Invalid BS date: ') . $e->getMessage());
        }

        return view('pages.support_team.attendance.class_report', $data);
    }
}
