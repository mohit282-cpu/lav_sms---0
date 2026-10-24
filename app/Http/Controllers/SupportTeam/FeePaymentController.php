<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Models\FeePayment;
use App\Models\Invoice;
use App\Models\MyClass;
use App\Models\Setting;
use App\Models\StudentRecord;
use App\Services\FeeManagementService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeePaymentController extends Controller
{
    protected $feeService;

    public function __construct(FeeManagementService $feeService)
    {
        $this->feeService = $feeService;
        $this->middleware('teamAccount')->except(['receipt', 'printReceipt']);
    }

    public function index(Request $req)
    {
        $academicYear = $req->academic_year ?: Qs::getCurrentSession();

        $query = FeePayment::where('academic_year', $academicYear)
            ->with(['student.student_record.my_class', 'receiver', 'invoice']);

        if ($req->filled('payment_method')) {
            $query->where('payment_method', $req->payment_method);
        }

        if ($req->filled('search')) {
            $search = $req->search;
            $query->where(function ($q) use ($search) {
                $q->where('receipt_no', 'LIKE', "%{$search}%")
                    ->orWhere('transaction_reference', 'LIKE', "%{$search}%")
                    ->orWhereHas('student', function ($sq) use ($search) {
                        $sq->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('username', 'LIKE', "%{$search}%");
                    });
            });
        }

        $d['academic_year'] = $academicYear;
        $d['payments'] = $query->orderBy('id', 'desc')->paginate(25);
        $d['selected_method'] = $req->payment_method;
        $d['search'] = $req->search;

        return view('pages.support_team.fees.payments.index', $d);
    }

    public function create(Request $req)
    {
        $d['academic_year'] = $academicYear = $req->academic_year ?: Qs::getCurrentSession();
        $d['classes'] = MyClass::orderBy('name')->get();

        $d['invoice'] = null;
        $d['student'] = null;

        if ($req->filled('invoice_id')) {
            $d['invoice'] = Invoice::with(['student.student_record.my_class', 'student.student_record.section'])->findOrFail($req->invoice_id);
            $d['student'] = $d['invoice']->student;
        } elseif ($req->filled('student_id')) {
            $d['student'] = User::with(['student_record.my_class', 'student_record.section'])->findOrFail($req->student_id);
            $d['student_invoices'] = Invoice::where('student_id', $req->student_id)
                ->whereIn('status', ['unpaid', 'partially_paid'])
                ->get();
        }

        return view('pages.support_team.fees.payments.create', $d);
    }

    public function store(Request $req)
    {
        $req->validate([
            'student_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,cheque,esewa,khalti,other',
            'invoice_id' => 'nullable|exists:invoices,id',
            'transaction_reference' => 'nullable|string|max:150',
            'payment_date' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $data = $req->all();
        $data['academic_year'] = $req->academic_year ?: Qs::getCurrentSession();
        $data['received_by'] = Auth::id() ?? 1;
        $data['is_date_bs'] = !empty($req->is_date_bs);

        $feePayment = $this->feeService->recordPayment($data);

        return redirect()->route('fees.receipts.show', $feePayment->id)
            ->with('flash_success', __('Payment recorded and receipt issued successfully.'));
    }

    public function receipt($payment_id)
    {
        $id = is_numeric($payment_id) ? $payment_id : Qs::decodeHash($payment_id);
        $payment = FeePayment::with(['student.student_record.my_class', 'student.student_record.section', 'receiver', 'invoice.items'])
            ->findOrFail($id);

        $this->authorizePaymentAccess($payment);

        $d['payment'] = $payment;
        $d['s'] = Setting::all()->flatMap(function ($s) {
            return [$s->type => $s->description];
        });

        return view('pages.support_team.fees.payments.receipt', $d);
    }

    public function printReceipt($payment_id)
    {
        $id = is_numeric($payment_id) ? $payment_id : Qs::decodeHash($payment_id);
        $payment = FeePayment::with(['student.student_record.my_class', 'student.student_record.section', 'receiver', 'invoice.items'])
            ->findOrFail($id);

        $this->authorizePaymentAccess($payment);

        $d['payment'] = $payment;
        $d['s'] = Setting::all()->flatMap(function ($s) {
            return [$s->type => $s->description];
        });

        return view('pages.support_team.fees.payments.print_receipt', $d);
    }

    protected function authorizePaymentAccess(FeePayment $payment)
    {
        if (Qs::userIsTeamAccount()) {
            return true;
        }

        $userId = Auth::id();
        if ($userId === (int) $payment->student_id) {
            return true;
        }

        if (Qs::userIsParent() && Qs::userIsMyChild($payment->student_id, $userId)) {
            return true;
        }

        abort(403, __('Access Denied. You are not authorized to view this receipt.'));
    }
}
