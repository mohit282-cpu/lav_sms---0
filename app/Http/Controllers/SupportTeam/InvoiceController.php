<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Models\FeeCategory;
use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\MyClass;
use App\Models\Section;
use App\Models\Setting;
use App\Models\StudentRecord;
use App\Services\FeeManagementService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    protected $feeService;

    public function __construct(FeeManagementService $feeService)
    {
        $this->feeService = $feeService;
        $this->middleware('teamAccount')->except(['show', 'print']);
    }

    public function index(Request $req)
    {
        $academicYear = $req->academic_year ?: Qs::getCurrentSession();

        $query = Invoice::where('academic_year', $academicYear)
            ->with(['student', 'my_class', 'section']);

        if ($req->filled('my_class_id')) {
            $query->where('my_class_id', $req->my_class_id);
        }
        if ($req->filled('status')) {
            $query->where('status', $req->status);
        }
        if ($req->filled('search')) {
            $search = $req->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'LIKE', "%{$search}%")
                    ->orWhereHas('student', function ($sq) use ($search) {
                        $sq->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('username', 'LIKE', "%{$search}%");
                    });
            });
        }

        $d['academic_year'] = $academicYear;
        $d['invoices'] = $query->orderBy('id', 'desc')->paginate(25);
        $d['classes'] = MyClass::orderBy('name')->get();
        $d['selected_class'] = $req->my_class_id;
        $d['selected_status'] = $req->status;
        $d['search'] = $req->search;

        return view('pages.support_team.fees.invoices.index', $d);
    }

    public function create(Request $req)
    {
        $academicYear = $req->academic_year ?: Qs::getCurrentSession();
        $d['academic_year'] = $academicYear;
        $d['classes'] = MyClass::orderBy('name')->get();
        $d['categories'] = FeeCategory::where('is_active', true)->orderBy('name')->get();

        $selectedClassId = $req->my_class_id;
        $d['selected_class_id'] = $selectedClassId;
        $d['students'] = [];
        $d['structures'] = [];

        if ($selectedClassId) {
            $d['students'] = StudentRecord::where('my_class_id', $selectedClassId)
                ->where('session', $academicYear)
                ->with('user')
                ->get()
                ->sortBy('user.name');

            $d['structures'] = FeeStructure::where('academic_year', $academicYear)
                ->where(function ($q) use ($selectedClassId) {
                    $q->whereNull('my_class_id')->orWhere('my_class_id', $selectedClassId);
                })
                ->where('is_active', true)
                ->with('category')
                ->get();
        }

        return view('pages.support_team.fees.invoices.create', $d);
    }

    public function store(Request $req)
    {
        $req->validate([
            'my_class_id' => 'required|exists:my_classes,id',
            'invoice_mode' => 'required|in:single,bulk',
            'student_id' => 'required_if:invoice_mode,single|nullable|exists:users,id',
            'fee_period' => 'required|string|max:100',
            'invoice_date' => 'nullable|string',
            'due_date' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.title' => 'required|string|max:150',
            'items.*.unit_price' => 'required|numeric|min:0.01',
        ]);

        $academicYear = $req->academic_year ?: Qs::getCurrentSession();

        $items = [];
        foreach ($req->items as $it) {
            if (empty($it['title']) || empty($it['unit_price'])) continue;
            $items[] = [
                'fee_category_id' => $it['fee_category_id'] ?? null,
                'fee_structure_id' => $it['fee_structure_id'] ?? null,
                'title' => $it['title'],
                'description' => $it['description'] ?? null,
                'unit_price' => (float) $it['unit_price'],
                'quantity' => (float) ($it['quantity'] ?? 1.00),
                'discount_amount' => (float) ($it['discount_amount'] ?? 0.00),
                'is_taxable' => !empty($it['is_taxable']),
                'tax_rate' => !empty($it['is_taxable']) ? (float) ($it['tax_rate'] ?? 0.00) : 0.00,
            ];
        }

        if (empty($items)) {
            return back()->with('flash_danger', __('Please add at least one valid line item.'));
        }

        $commonData = [
            'my_class_id' => $req->my_class_id,
            'academic_year' => $academicYear,
            'fee_period' => $req->fee_period,
            'invoice_date' => $req->invoice_date,
            'is_date_bs' => !empty($req->is_date_bs),
            'due_date' => $req->due_date,
            'is_due_date_bs' => !empty($req->is_due_date_bs),
            'notes' => $req->notes,
            'created_by' => Auth::id() ?? 1,
        ];

        if ($req->invoice_mode === 'single') {
            $studentRec = StudentRecord::where('user_id', $req->student_id)->first();
            $invData = array_merge($commonData, [
                'student_id' => $req->student_id,
                'section_id' => $studentRec ? $studentRec->section_id : null,
                'idempotency_token' => $req->idempotency_token ?: ('INV-' . $req->student_id . '-' . md5($req->fee_period . time())),
            ]);

            $invoice = $this->feeService->generateInvoice($invData, $items);

            return redirect()->route('fees.invoices.show', $invoice->id)
                ->with('flash_success', __('Invoice created successfully.'));
        }

        // Bulk Generation for entire class
        $students = StudentRecord::where('my_class_id', $req->my_class_id)
            ->where('session', $academicYear)
            ->get();

        if ($students->isEmpty()) {
            return back()->with('flash_danger', __('No students found in the selected class for this session.'));
        }

        $count = 0;
        foreach ($students as $st) {
            $invData = array_merge($commonData, [
                'student_id' => $st->user_id,
                'section_id' => $st->section_id,
                'idempotency_token' => 'BULK-' . $st->user_id . '-' . md5($req->fee_period . '-' . $academicYear),
            ]);

            $this->feeService->generateInvoice($invData, $items);
            $count++;
        }

        return redirect()->route('fees.invoices.index', ['my_class_id' => $req->my_class_id])
            ->with('flash_success', __(':count invoices generated successfully.', ['count' => $count]));
    }

    public function show($invoice_id)
    {
        $id = is_numeric($invoice_id) ? $invoice_id : Qs::decodeHash($invoice_id);
        $invoice = Invoice::with(['student.student_record.my_class', 'student.student_record.section', 'my_class', 'section', 'items.category', 'payments', 'adjustments'])
            ->findOrFail($id);

        $this->authorizeInvoiceAccess($invoice);

        $d['invoice'] = $invoice;
        $d['settings'] = Setting::all()->flatMap(function ($s) {
            return [$s->type => $s->description];
        });

        return view('pages.support_team.fees.invoices.show', $d);
    }

    public function print($invoice_id)
    {
        $id = is_numeric($invoice_id) ? $invoice_id : Qs::decodeHash($invoice_id);
        $invoice = Invoice::with(['student.student_record.my_class', 'student.student_record.section', 'my_class', 'section', 'items.category', 'payments', 'adjustments'])
            ->findOrFail($id);

        $this->authorizeInvoiceAccess($invoice);

        $d['invoice'] = $invoice;
        $d['s'] = Setting::all()->flatMap(function ($s) {
            return [$s->type => $s->description];
        });

        return view('pages.support_team.fees.invoices.print', $d);
    }

    protected function authorizeInvoiceAccess(Invoice $invoice)
    {
        if (Qs::userIsTeamAccount()) {
            return true;
        }

        $userId = Auth::id();
        if ($userId === (int) $invoice->student_id) {
            return true;
        }

        if (Qs::userIsParent() && Qs::userIsMyChild($invoice->student_id, $userId)) {
            return true;
        }

        abort(403, __('Access Denied. You are not authorized to view this invoice.'));
    }
}
