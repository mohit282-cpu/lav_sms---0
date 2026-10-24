<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Models\FeeAdjustment;
use App\Models\FeePayment;
use App\Models\Invoice;
use App\Models\MyClass;
use App\Models\StudentRecord;
use App\Services\FeeManagementService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeAdjustmentController extends Controller
{
    protected $feeService;

    public function __construct(FeeManagementService $feeService)
    {
        $this->feeService = $feeService;
        $this->middleware('teamAccount');
    }

    public function index(Request $req)
    {
        $academicYear = $req->academic_year ?: Qs::getCurrentSession();

        $query = FeeAdjustment::where('academic_year', $academicYear)
            ->with(['student.student_record.my_class', 'authorizer', 'invoice', 'payment']);

        if ($req->filled('adjustment_type')) {
            $query->where('adjustment_type', $req->adjustment_type);
        }

        $d['academic_year'] = $academicYear;
        $d['adjustments'] = $query->orderBy('id', 'desc')->paginate(25);
        $d['selected_type'] = $req->adjustment_type;

        return view('pages.support_team.fees.adjustments.index', $d);
    }

    public function create(Request $req)
    {
        $d['academic_year'] = $academicYear = $req->academic_year ?: Qs::getCurrentSession();
        $d['classes'] = MyClass::orderBy('name')->get();

        $d['student'] = null;
        $d['invoice'] = null;
        $d['payment'] = null;

        if ($req->filled('student_id')) {
            $d['student'] = User::with(['student_record.my_class', 'student_record.section'])->findOrFail($req->student_id);
            $d['invoices'] = Invoice::where('student_id', $req->student_id)
                ->where('status', '!=', 'cancelled')
                ->where('balance', '>', 0)
                ->get();
            $d['payments'] = FeePayment::where('student_id', $req->student_id)
                ->whereIn('status', ['completed', 'partially_refunded'])
                ->get();
        }

        return view('pages.support_team.fees.adjustments.create', $d);
    }

    public function store(Request $req)
    {
        $req->validate([
            'student_id' => 'required|exists:users,id',
            'adjustment_type' => 'required|in:discount,waiver,scholarship,refund,correction',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|min:5|max:500',
            'invoice_id' => 'nullable|exists:invoices,id',
            'fee_payment_id' => 'required_if:adjustment_type,refund|nullable|exists:fee_payments,id',
            'adjustment_date' => 'nullable|string',
        ]);

        $data = $req->all();
        $data['academic_year'] = $req->academic_year ?: Qs::getCurrentSession();
        $data['authorized_by'] = Auth::id() ?? 1;
        $data['is_date_bs'] = !empty($req->is_date_bs);

        $this->feeService->applyAdjustment($data);

        return redirect()->route('fees.adjustments.index')
            ->with('flash_success', __('Fee adjustment/refund processed successfully.'));
    }
}
