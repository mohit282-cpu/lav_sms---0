<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\AttendanceAuditTrail;
use App\Models\Holiday;
use App\Models\MyClass;
use App\Models\Section;
use App\Models\StaffAttendance;
use App\Models\StudentAttendance;
use App\Models\StudentRecord;
use App\Services\AttendanceService;
use App\User;
use Tests\TestCase;

class NepalAttendanceManagementTest extends TestCase
{
    protected function getAdmin()
    {
        return User::where('user_type', 'super_admin')->first();
    }

    protected function getTeacher()
    {
        return User::where('user_type', 'teacher')->first();
    }

    protected function getStudent()
    {
        return User::where('user_type', 'student')->first();
    }

    protected function getParent()
    {
        return User::where('user_type', 'parent')->first();
    }

    protected function setUp(): void
    {
        parent::setUp();
        // Clean test attendances and audit trails
        StudentAttendance::whereIn('attendance_date_bs', ['2083-07-08', '2083-07-09'])->delete();
        StaffAttendance::whereIn('attendance_date_bs', ['2083-07-08', '2083-07-09'])->delete();
        AttendanceAuditTrail::whereIn('attendance_date_bs', ['2083-07-08', '2083-07-09'])->delete();
    }

    /**
     * Test admin can view student daily attendance page.
     */
    public function test_admin_can_view_student_attendance_page()
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get(route('attendance.index'));
        $response->assertStatus(200);
        $response->assertSee('Student Daily Attendance');
    }

    /**
     * Test recording daily student attendance with BS date and AD conversion.
     */
    public function test_admin_can_record_bulk_student_attendance()
    {
        $admin = $this->getAdmin();
        $class = MyClass::first();
        $students = StudentRecord::where('my_class_id', $class->id)->take(3)->get();

        $this->assertNotEmpty($students, 'There must be students in the class.');

        $studentsData = [];
        foreach ($students as $idx => $s) {
            $status = ($idx === 0) ? 'present' : (($idx === 1) ? 'absent' : 'late');
            $studentsData[$s->id] = [
                'status' => $status,
                'remarks' => ($status === 'late') ? 'Late by 15 mins' : '',
            ];
        }

        $postData = [
            'my_class_id' => $class->id,
            'attendance_date_bs' => '2083-07-08',
            'students' => $studentsData,
        ];

        $response = $this->actingAs($admin)->post(route('attendance.store'), $postData);
        $response->assertSessionHas('flash_success');

        // Verify records in DB
        foreach ($students as $idx => $s) {
            $expectedStatus = ($idx === 0) ? 'present' : (($idx === 1) ? 'absent' : 'late');
            $att = StudentAttendance::where('student_record_id', $s->id)
                ->where('attendance_date_bs', '2083-07-08')
                ->first();

            $this->assertNotNull($att);
            $this->assertEquals($expectedStatus, $att->status);
            $this->assertEquals('2026-10-25', $att->attendance_date->format('Y-m-d')); // 2083-07-08 BS is 2026-10-25 AD
        }

        // Verify audit trail created
        $auditCount = AttendanceAuditTrail::where('attendance_date_bs', '2083-07-08')
            ->where('attendance_type', 'student')
            ->where('action', 'create')
            ->count();
        $this->assertEquals(count($students), $auditCount);
    }

    /**
     * Test duplicate attendance prevention and updating with audit trail.
     */
    public function test_updating_existing_attendance_creates_update_audit_trail()
    {
        $admin = $this->getAdmin();
        $class = MyClass::first();
        $student = StudentRecord::where('my_class_id', $class->id)->first();

        // 1. First record as absent
        $this->actingAs($admin)->post(route('attendance.store'), [
            'my_class_id' => $class->id,
            'attendance_date_bs' => '2083-07-08',
            'students' => [
                $student->id => ['status' => 'absent', 'remarks' => 'Fever'],
            ],
        ]);

        $att = StudentAttendance::where('student_record_id', $student->id)
            ->where('attendance_date_bs', '2083-07-08')
            ->first();
        $this->assertEquals('absent', $att->status);

        // 2. Teacher/Admin corrects to present with doctor note
        $this->actingAs($admin)->post(route('attendance.store'), [
            'my_class_id' => $class->id,
            'attendance_date_bs' => '2083-07-08',
            'students' => [
                $student->id => ['status' => 'leave', 'remarks' => 'Approved medical leave'],
            ],
        ]);

        $att->refresh();
        $this->assertEquals('leave', $att->status);
        $this->assertEquals('Approved medical leave', $att->remarks);

        // Verify audit trail captured old status and new status
        $updateAudit = AttendanceAuditTrail::where('attendance_id', $att->id)
            ->where('action', 'update')
            ->first();

        $this->assertNotNull($updateAudit);
        $this->assertEquals('absent', $updateAudit->old_status);
        $this->assertEquals('leave', $updateAudit->new_status);
        $this->assertEquals($admin->id, $updateAudit->modified_by);
    }

    /**
     * Test teacher permissions: unassigned teacher cannot record attendance for other class.
     */
    public function test_unassigned_teacher_cannot_record_attendance()
    {
        $teacher = $this->getTeacher();
        $class = MyClass::first();
        $student = StudentRecord::where('my_class_id', $class->id)->first();

        // Ensure teacher is NOT assigned to this section
        Section::where('my_class_id', $class->id)->update(['teacher_id' => null]);

        $response = $this->actingAs($teacher)->post(route('attendance.store'), [
            'my_class_id' => $class->id,
            'attendance_date_bs' => '2083-07-08',
            'students' => [
                $student->id => ['status' => 'present', 'remarks' => ''],
            ],
        ]);

        // Must be rejected with 403 Forbidden
        $response->assertStatus(403);
    }

    /**
     * Test student privacy: student cannot view other students' attendance history.
     */
    public function test_student_cannot_view_other_students_attendance()
    {
        $studentUser = $this->getStudent();
        $myRecord = StudentRecord::where('user_id', $studentUser->id)->first();
        $otherRecord = StudentRecord::where('user_id', '!=', $studentUser->id)->first();

        // Student viewing own attendance -> 200 OK
        if ($myRecord) {
            $resOwn = $this->actingAs($studentUser)->get(route('attendance.student_history', $myRecord->id));
            $resOwn->assertStatus(200);
        }

        // Student attempting to view other student's attendance -> 403 Forbidden
        $resOther = $this->actingAs($studentUser)->get(route('attendance.student_history', $otherRecord->id));
        $resOther->assertStatus(403);
    }

    /**
     * Test calendar integration: warns when attendance is inspected on configured holiday.
     */
    public function test_calendar_holiday_inspection_and_warning()
    {
        $admin = $this->getAdmin();

        // Create a test holiday
        Holiday::where('title', 'Dashain Festival Break')->delete();
        $holiday = Holiday::create([
            'title' => 'Dashain Festival Break',
            'start_date' => '2026-10-25', // 2083-07-08 BS
            'end_date' => '2026-10-26',
            'start_date_bs' => '2083-07-08',
            'end_date_bs' => '2083-07-09',
            'type' => 'public_holiday',
            'is_closure' => true,
        ]);

        $attendanceService = app(AttendanceService::class);
        $inspection = $attendanceService->inspectAttendanceDate('2083-07-08');

        $this->assertTrue($inspection['is_holiday']);
        $this->assertStringContainsString('Dashain Festival', $inspection['warning']);

        $holiday->delete();
    }

    /**
     * Test attendance stats and percentage calculation rules.
     */
    public function test_attendance_percentage_computation_rules()
    {
        $attendanceService = app(AttendanceService::class);

        // 10 records: 7 present, 1 late, 1 half-day, 1 absent
        $records = collect([
            (object)['status' => 'present'],
            (object)['status' => 'present'],
            (object)['status' => 'present'],
            (object)['status' => 'present'],
            (object)['status' => 'present'],
            (object)['status' => 'present'],
            (object)['status' => 'present'],
            (object)['status' => 'late'],
            (object)['status' => 'half_day'],
            (object)['status' => 'absent'],
        ]);

        $stats = $attendanceService->computeAttendanceStats($records);

        // effective present = 7 + 1 + 0.5 = 8.5 out of 10 = 85.0%
        $this->assertEquals(10, $stats['total_days']);
        $this->assertEquals(7, $stats['present']);
        $this->assertEquals(1, $stats['late']);
        $this->assertEquals(1, $stats['half_day']);
        $this->assertEquals(1, $stats['absent']);
        $this->assertEquals(8.5, $stats['effective_present']);
        $this->assertEquals(85.0, $stats['percentage']);
    }

    /**
     * Test admin can record and view staff daily attendance.
     */
    public function test_admin_can_record_staff_daily_attendance()
    {
        $admin = $this->getAdmin();
        $staffUser = User::whereIn('user_type', ['teacher', 'accountant'])->first();

        $response = $this->actingAs($admin)->post(route('staff_attendance.store'), [
            'attendance_date_bs' => '2083-07-08',
            'staff' => [
                $staffUser->id => ['status' => 'present', 'remarks' => 'On time'],
            ],
        ]);

        $response->assertSessionHas('flash_success');

        $staffAtt = StaffAttendance::where('user_id', $staffUser->id)
            ->where('attendance_date_bs', '2083-07-08')
            ->first();

        $this->assertNotNull($staffAtt);
        $this->assertEquals('present', $staffAtt->status);
        $this->assertEquals('On time', $staffAtt->remarks);
    }

    /**
     * Test monthly attendance matrix generation.
     */
    public function test_monthly_class_attendance_matrix_loads_correctly()
    {
        $admin = $this->getAdmin();
        $class = MyClass::first();

        $response = $this->actingAs($admin)->get(route('attendance.monthly', [
            'my_class_id' => $class->id,
            'year_bs' => 2083,
            'month_bs' => 7,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Kartik');
        $response->assertSee('Attendance Sheet');
    }

    /**
     * Test class-wise daily attendance comparison report.
     */
    public function test_class_comparison_report_loads()
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get(route('attendance.class_report', [
            'attendance_date_bs' => '2083-07-08',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Attendance Overview by Class');
    }
}
