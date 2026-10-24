<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Models\MyClass;
use App\Models\Setting;
use App\Models\StudentRecord;
use App\Services\FeeManagementService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLedgerController extends Controller
{
    protected $feeService;

    public function __construct(FeeManagementService $feeService)
    {
        $this->feeService = $feeService;
        $this->middleware('teamAccount')->except(['show', 'print']);
    }

    public function index(Request $req)
    {
        $d['academic_year'] = $academicYear = $req->academic_year ?: Qs::getCurrentSession();
        $d['classes'] = MyClass::orderBy('name')->get();
        $d['selected_class_id'] = $req->my_class_id;
        $d['students'] = [];

        if ($req->filled('my_class_id')) {
            $d['students'] = StudentRecord::where('my_class_id', $req->my_class_id)
                ->where('session', $academicYear)
                ->with('user')
                ->get()
                ->sortBy('user.name');
        }

        return view('pages.support_team.fees.ledger.index', $d);
    }

    public function show($student_id, Request $req)
    {
        $this->authorizeLedgerAccess($student_id);

        $academicYear = $req->academic_year ?: Qs::getCurrentSession();
        $ledgerData = $this->feeService->getStudentLedger($student_id, $academicYear);

        $d = array_merge($ledgerData, [
            's' => Setting::all()->flatMap(function ($s) {
                return [$s->type => $s->description];
            }),
        ]);

        return view('pages.support_team.fees.ledger.show', $d);
    }

    public function print($student_id, Request $req)
    {
        $this->authorizeLedgerAccess($student_id);

        $academicYear = $req->academic_year ?: Qs::getCurrentSession();
        $ledgerData = $this->feeService->getStudentLedger($student_id, $academicYear);

        $d = array_merge($ledgerData, [
            's' => Setting::all()->flatMap(function ($s) {
                return [$s->type => $s->description];
            }),
        ]);

        return view('pages.support_team.fees.ledger.print', $d);
    }

    protected function authorizeLedgerAccess($student_id)
    {
        if (Qs::userIsTeamAccount()) {
            return true;
        }

        $userId = Auth::id();
        if ($userId === (int) $student_id) {
            return true;
        }

        if (Qs::userIsParent() && Qs::userIsMyChild($student_id, $userId)) {
            return true;
        }

        abort(403, __('Access Denied. You are not authorized to view this student fee ledger.'));
    }
}
