<?php

namespace Tests\Feature;

use App\Helpers\Qs;
use App\Models\ClassType;
use App\Models\FeeAdjustment;
use App\Models\FeeCategory;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\MyClass;
use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Models\Receipt;
use App\Models\Section;
use App\Models\StudentRecord;
use App\Services\FeeManagementService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NepalFeeManagementTest extends TestCase
{
    protected $admin;
    protected $accountant;
    protected $studentUser;
    protected $studentUser2;
    protected $studentRecord;
    protected $studentRecord2;
    protected $myClass;
    protected $section;
    protected $feeService;
    protected $academicYear;

    protected function setUp(): void
    {
        parent::setUp();

        $this->feeService = app(FeeManagementService::class);
        $this->academicYear = Qs::getCurrentSession() ?: '2083/84 BS';

        $this->admin = User::firstOrCreate(
            ['email' => 'admin_fee_test@example.com'],
            [
                'name' => 'Fee Super Admin',
                'username' => 'admin_fee_test',
                'password' => bcrypt('password'),
                'user_type' => 'super_admin',
                'code' => strtoupper(substr(md5(uniqid()), 0, 10)),
            ]
        );

        $this->accountant = User::firstOrCreate(
            ['email' => 'accountant_fee_test@example.com'],
            [
                'name' => 'School Accountant',
                'username' => 'accountant_fee_test',
                'password' => bcrypt('password'),
                'user_type' => 'accountant',
                'code' => strtoupper(substr(md5(uniqid()), 0, 10)),
            ]
        );

        $classType = ClassType::first();
        $this->myClass = MyClass::firstOrCreate(
            ['name' => 'Grade 8 Fee Test'],
            ['class_type_id' => $classType ? $classType->id : 1]
        );

        $this->section = Section::firstOrCreate(
            ['name' => 'A Fee', 'my_class_id' => $this->myClass->id]
        );

        $this->studentUser = User::create([
            'name' => 'Aayush Shrestha',
            'username' => 'aayush_' . uniqid(),
            'password' => bcrypt('password'),
            'user_type' => 'student',
            'code' => strtoupper(substr(md5(uniqid()), 0, 10)),
        ]);

        $this->studentRecord = StudentRecord::create([
            'user_id' => $this->studentUser->id,
            'my_class_id' => $this->myClass->id,
            'section_id' => $this->section->id,
            'adm_no' => 'ADM-FEE-' . rand(1000, 9999),
            'session' => $this->academicYear,
        ]);

        $this->studentUser2 = User::create([
            'name' => 'Bikash Thapa',
            'username' => 'bikash_' . uniqid(),
            'password' => bcrypt('password'),
            'user_type' => 'student',
            'code' => strtoupper(substr(md5(uniqid()), 0, 10)),
        ]);

        $this->studentRecord2 = StudentRecord::create([
            'user_id' => $this->studentUser2->id,
            'my_class_id' => $this->myClass->id,
            'section_id' => $this->section->id,
            'adm_no' => 'ADM-FEE-' . rand(1000, 9999),
            'session' => $this->academicYear,
        ]);
    }

    protected function tearDown(): void
    {
        // Clean up created student users
        if ($this->studentRecord) $this->studentRecord->delete();
        if ($this->studentRecord2) $this->studentRecord2->delete();
        if ($this->studentUser) $this->studentUser->delete();
        if ($this->studentUser2) $this->studentUser2->delete();

        parent::tearDown();
    }

    public function test_admin_can_create_fee_category_and_structure()
    {
        $response = $this->actingAs($this->admin)->post(route('fees.categories.store'), [
            'name' => 'Science Practical Lab Fee',
            'code' => 'SCI_LAB_' . rand(100, 999),
            'fee_type' => 'lab',
            'description' => 'Chemicals and apparatus charges',
            'is_taxable' => 0,
        ]);

        $response->assertRedirect();

        $category = FeeCategory::where('name', 'Science Practical Lab Fee')->latest()->first();
        $this->assertNotNull($category);

        $structResponse = $this->actingAs($this->admin)->post(route('fees.structures.store'), [
            'title' => 'Grade 8 Science Lab Charge',
            'fee_category_id' => $category->id,
            'amount' => 1500.00,
            'period_type' => 'term',
            'my_class_id' => $this->myClass->id,
            'academic_year' => $this->academicYear,
            'due_day' => 15,
        ]);

        $structResponse->assertRedirect();
        $structure = FeeStructure::where('title', 'Grade 8 Science Lab Charge')->first();
        $this->assertNotNull($structure);
        $this->assertEquals(1500.00, $structure->amount);
    }

    public function test_admin_can_generate_student_invoice_with_line_items()
    {
        $category = FeeCategory::first();

        $response = $this->actingAs($this->accountant)->post(route('fees.invoices.store'), [
            'my_class_id' => $this->myClass->id,
            'invoice_mode' => 'single',
            'student_id' => $this->studentUser->id,
            'fee_period' => '2083 Baishakh Tuition',
            'invoice_date' => '2083-01-05',
            'is_date_bs' => 1,
            'due_date' => '2083-01-20',
            'is_due_date_bs' => 1,
            'items' => [
                [
                    'fee_category_id' => $category ? $category->id : null,
                    'title' => 'Monthly Tuition Fee',
                    'unit_price' => 4000.00,
                    'quantity' => 1,
                    'discount_amount' => 500.00,
                    'is_taxable' => 0,
                ],
                [
                    'fee_category_id' => $category ? $category->id : null,
                    'title' => 'Computer Lab Fee',
                    'unit_price' => 1000.00,
                    'quantity' => 1,
                    'discount_amount' => 0.00,
                    'is_taxable' => 1,
                    'tax_rate' => 13.00, // 13% of 1000 = 130
                ],
            ],
        ]);

        $response->assertRedirect();

        $invoice = Invoice::where('student_id', $this->studentUser->id)->latest()->first();
        $this->assertNotNull($invoice);
        $this->assertStringStartsWith('INV-', $invoice->invoice_no);
        $this->assertEquals('unpaid', $invoice->status);

        // Subtotal: 4000 + 1000 = 5000. Discount: 500. Tax: 130. Net: 4630.
        $this->assertEquals(5000.00, $invoice->subtotal);
        $this->assertEquals(500.00, $invoice->discount_amount);
        $this->assertEquals(130.00, $invoice->tax_amount);
        $this->assertEquals(4630.00, $invoice->net_total);
        $this->assertEquals(4630.00, $invoice->balance);
    }

    public function test_partial_and_full_payment_updates_invoice_and_issues_receipt()
    {
        $invoice = $this->feeService->generateInvoice([
            'student_id' => $this->studentUser->id,
            'my_class_id' => $this->myClass->id,
            'academic_year' => $this->academicYear,
            'fee_period' => '2083 Jestha Tuition',
            'created_by' => $this->accountant->id,
        ], [
            [
                'title' => 'Tuition Fee',
                'unit_price' => 3000.00,
                'quantity' => 1,
            ],
        ]);

        $this->assertEquals(3000.00, $invoice->net_total);
        $this->assertEquals('unpaid', $invoice->status);

        // 1. Partial Payment of Rs 1000
        $pay1 = $this->feeService->recordPayment([
            'student_id' => $this->studentUser->id,
            'invoice_id' => $invoice->id,
            'amount' => 1000.00,
            'payment_method' => 'esewa',
            'transaction_reference' => 'ESEWA-REF-12345',
            'academic_year' => $this->academicYear,
            'received_by' => $this->accountant->id,
        ]);

        $this->assertStringStartsWith('REC-', $pay1->receipt_no);
        $invoice->refresh();
        $this->assertEquals(1000.00, $invoice->paid_amount);
        $this->assertEquals(2000.00, $invoice->balance);
        $this->assertEquals('partially_paid', $invoice->status);

        // 2. Full remaining payment of Rs 2000
        $pay2 = $this->feeService->recordPayment([
            'student_id' => $this->studentUser->id,
            'invoice_id' => $invoice->id,
            'amount' => 2000.00,
            'payment_method' => 'cash',
            'academic_year' => $this->academicYear,
            'received_by' => $this->accountant->id,
        ]);

        $invoice->refresh();
        $this->assertEquals(3000.00, $invoice->paid_amount);
        $this->assertEquals(0.00, $invoice->balance);
        $this->assertEquals('paid', $invoice->status);
        $this->assertNotEquals($pay1->receipt_no, $pay2->receipt_no);
    }

    public function test_duplicate_payment_submission_is_prevented_via_idempotency()
    {
        $token = 'IDEMPOTENT-TEST-' . uniqid();

        $payment1 = $this->feeService->recordPayment([
            'student_id' => $this->studentUser->id,
            'amount' => 1200.00,
            'payment_method' => 'bank_transfer',
            'idempotency_token' => $token,
            'received_by' => $this->accountant->id,
            'academic_year' => $this->academicYear,
        ]);

        // Attempt second submission with same token
        $payment2 = $this->feeService->recordPayment([
            'student_id' => $this->studentUser->id,
            'amount' => 1200.00,
            'payment_method' => 'bank_transfer',
            'idempotency_token' => $token,
            'received_by' => $this->accountant->id,
            'academic_year' => $this->academicYear,
        ]);

        $this->assertEquals($payment1->id, $payment2->id);
        $this->assertEquals($payment1->receipt_no, $payment2->receipt_no);
    }

    public function test_admin_can_apply_authorized_waiver_or_discount()
    {
        $invoice = $this->feeService->generateInvoice([
            'student_id' => $this->studentUser->id,
            'my_class_id' => $this->myClass->id,
            'academic_year' => $this->academicYear,
            'fee_period' => '2083 Ashadh Tuition',
            'created_by' => $this->accountant->id,
        ], [
            [
                'title' => 'Tuition Fee',
                'unit_price' => 5000.00,
                'quantity' => 1,
            ],
        ]);

        $adj = $this->feeService->applyAdjustment([
            'student_id' => $this->studentUser->id,
            'invoice_id' => $invoice->id,
            'adjustment_type' => 'waiver',
            'amount' => 1000.00,
            'reason' => 'Approved financial hardship sibling fee concession',
            'authorized_by' => $this->admin->id,
            'academic_year' => $this->academicYear,
        ]);

        $this->assertStringStartsWith('ADJ-', $adj->adjustment_no);
        $invoice->refresh();
        $this->assertEquals(4000.00, $invoice->net_total);
        $this->assertEquals(4000.00, $invoice->balance);
    }

    public function test_traceable_refund_cannot_exceed_payment_amount()
    {
        $payment = $this->feeService->recordPayment([
            'student_id' => $this->studentUser->id,
            'amount' => 2500.00,
            'payment_method' => 'bank_transfer',
            'received_by' => $this->accountant->id,
            'academic_year' => $this->academicYear,
        ]);

        // Partial refund of 1000
        $refund1 = $this->feeService->applyAdjustment([
            'student_id' => $this->studentUser->id,
            'fee_payment_id' => $payment->id,
            'adjustment_type' => 'refund',
            'amount' => 1000.00,
            'reason' => 'Excess bus fee refund for lockdown period',
            'authorized_by' => $this->admin->id,
            'academic_year' => $this->academicYear,
        ]);

        $this->assertStringStartsWith('REF-', $refund1->adjustment_no);
        $payment->refresh();
        $this->assertEquals('partially_refunded', $payment->status);

        // Attempt refunding more than remaining 1500
        $this->expectException(\InvalidArgumentException::class);
        $this->feeService->applyAdjustment([
            'student_id' => $this->studentUser->id,
            'fee_payment_id' => $payment->id,
            'adjustment_type' => 'refund',
            'amount' => 2000.00, // exceeds remaining 1500
            'reason' => 'Attempting excessive refund',
            'authorized_by' => $this->admin->id,
            'academic_year' => $this->academicYear,
        ]);
    }

    public function test_student_fee_ledger_calculates_debits_credits_and_running_balance()
    {
        $ledger = $this->feeService->getStudentLedger($this->studentUser->id, $this->academicYear);

        $this->assertArrayHasKey('total_debit', $ledger);
        $this->assertArrayHasKey('total_credit', $ledger);
        $this->assertArrayHasKey('net_outstanding', $ledger);
        $this->assertEquals($ledger['total_debit'] - $ledger['total_credit'], $ledger['net_outstanding']);
    }

    public function test_student_cannot_view_other_students_invoice_or_ledger()
    {
        $invoice2 = $this->feeService->generateInvoice([
            'student_id' => $this->studentUser2->id,
            'my_class_id' => $this->myClass->id,
            'academic_year' => $this->academicYear,
            'fee_period' => '2083 Privacy Test',
            'created_by' => $this->accountant->id,
        ], [
            ['title' => 'Fee', 'unit_price' => 1000, 'quantity' => 1],
        ]);

        $response = $this->actingAs($this->studentUser)->get(route('fees.invoices.show', $invoice2->id));
        $response->assertStatus(403);

        // Student 1 attempts to view Student 2's ledger
        $ledgerResp = $this->actingAs($this->studentUser)->get(route('fees.ledger.show', $this->studentUser2->id));
        $ledgerResp->assertStatus(403);

        // Student 1 can view their own ledger
        $ownLedger = $this->actingAs($this->studentUser)->get(route('fees.ledger.show', $this->studentUser->id));
        $ownLedger->assertStatus(200);
    }

    public function test_financial_reports_reconcile_only_actual_completed_payments()
    {
        $reports = $this->feeService->getFinancialReports(['academic_year' => $this->academicYear]);

        $this->assertArrayHasKey('daily_collection', $reports);
        $this->assertArrayHasKey('payment_methods', $reports);
        $this->assertArrayHasKey('class_collection', $reports);
        $this->assertArrayHasKey('outstanding_invoices', $reports);
        $this->assertArrayHasKey('total_revenue_collected', $reports);

        // Revenue matches sum of payment methods
        $methodsSum = array_sum(array_filter($reports['payment_methods'], function ($k) {
            return $k !== 'total';
        }, ARRAY_FILTER_USE_KEY));

        $this->assertEquals($methodsSum, $reports['total_revenue_collected']);
    }

    public function test_existing_legacy_payment_records_remain_preserved()
    {
        $legacyPaymentCount = Payment::count();
        $legacyRecordCount = PaymentRecord::count();
        $legacyReceiptCount = Receipt::count();

        $this->assertGreaterThanOrEqual(1, $legacyPaymentCount);
        $this->assertGreaterThanOrEqual(1, $legacyRecordCount);
        $this->assertGreaterThanOrEqual(1, $legacyReceiptCount);
    }
}
