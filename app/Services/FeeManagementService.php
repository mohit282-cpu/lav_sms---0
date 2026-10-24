<?php

namespace App\Services;

use App\Helpers\NepaliHelper;
use App\Helpers\Qs;
use App\Models\FeeAdjustment;
use App\Models\FeeCategory;
use App\Models\FeePayment;
use App\Models\FeePaymentAllocation;
use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\MyClass;
use App\Models\Section;
use App\Models\StudentLedgerEntry;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class FeeManagementService
{
    /**
     * @var BikramSambatService
     */
    protected $bsService;

    public function __construct(BikramSambatService $bsService)
    {
        $this->bsService = $bsService;
    }

    /**
     * Normalize date to AD string (Y-m-d) and BS string (Y-m-d).
     *
     * @param string|null $dateStr
     * @param bool $isBs
     * @return array [ad => 'YYYY-MM-DD', bs => 'YYYY-MM-DD']
     */
    public function resolveDates($dateStr = null, $isBs = false)
    {
        if (!$dateStr) {
            $now = Carbon::now();
            $bs = $this->bsService->adToBs($now);
            return [
                'ad' => $now->format('Y-m-d'),
                'bs' => $bs['bs_date'],
            ];
        }

        if ($isBs) {
            $adData = $this->bsService->bsToAd($dateStr);
            return [
                'ad' => $adData['ad_date'],
                'bs' => $dateStr,
            ];
        }

        $bsData = $this->bsService->adToBs($dateStr);
        return [
            'ad' => Carbon::parse($dateStr)->format('Y-m-d'),
            'bs' => $bsData['bs_date'],
        ];
    }

    /**
     * Generate unique collision-resistant Invoice Number.
     * Format: INV-YEAR_BS-00001
     *
     * @param string $academicYear
     * @return string
     */
    public function generateInvoiceNumber($academicYear)
    {
        $cleanYear = preg_replace('/[^0-9]/', '', substr($academicYear, 0, 4));
        if (empty($cleanYear)) {
            $cleanYear = date('Y');
        }

        $prefix = "INV-{$cleanYear}-";
        $latest = Invoice::where('invoice_no', 'LIKE', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->lockForUpdate()
            ->first();

        $seq = 1;
        if ($latest && preg_match('/(\d+)$/', $latest->invoice_no, $m)) {
            $seq = ((int) $m[1]) + 1;
        }

        $candidate = sprintf('%s%05d', $prefix, $seq);
        while (Invoice::where('invoice_no', $candidate)->exists()) {
            $seq++;
            $candidate = sprintf('%s%05d', $prefix, $seq);
        }

        return $candidate;
    }

    /**
     * Generate unique collision-resistant Receipt Number.
     * Format: REC-YEAR_BS-00001
     *
     * @param string $academicYear
     * @return string
     */
    public function generateReceiptNumber($academicYear)
    {
        $cleanYear = preg_replace('/[^0-9]/', '', substr($academicYear, 0, 4));
        if (empty($cleanYear)) {
            $cleanYear = date('Y');
        }

        $prefix = "REC-{$cleanYear}-";
        $latest = FeePayment::where('receipt_no', 'LIKE', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->lockForUpdate()
            ->first();

        $seq = 1;
        if ($latest && preg_match('/(\d+)$/', $latest->receipt_no, $m)) {
            $seq = ((int) $m[1]) + 1;
        }

        $candidate = sprintf('%s%05d', $prefix, $seq);
        while (FeePayment::where('receipt_no', $candidate)->exists()) {
            $seq++;
            $candidate = sprintf('%s%05d', $prefix, $seq);
        }

        return $candidate;
    }

    /**
     * Generate unique collision-resistant Adjustment/Refund Number.
     * Format: ADJ-YEAR_BS-00001 / REF-YEAR_BS-00001
     *
     * @param string $academicYear
     * @param string $type
     * @return string
     */
    public function generateAdjustmentNumber($academicYear, $type = 'discount')
    {
        $prefixChar = ($type === 'refund') ? 'REF' : 'ADJ';
        $cleanYear = preg_replace('/[^0-9]/', '', substr($academicYear, 0, 4));
        if (empty($cleanYear)) {
            $cleanYear = date('Y');
        }

        $prefix = "{$prefixChar}-{$cleanYear}-";
        $latest = FeeAdjustment::where('adjustment_no', 'LIKE', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->lockForUpdate()
            ->first();

        $seq = 1;
        if ($latest && preg_match('/(\d+)$/', $latest->adjustment_no, $m)) {
            $seq = ((int) $m[1]) + 1;
        }

        $candidate = sprintf('%s%05d', $prefix, $seq);
        while (FeeAdjustment::where('adjustment_no', $candidate)->exists()) {
            $seq++;
            $candidate = sprintf('%s%05d', $prefix, $seq);
        }

        return $candidate;
    }

    /**
     * Create or update Fee Structure.
     *
     * @param array $data
     * @return FeeStructure
     */
    public function saveFeeStructure(array $data)
    {
        $data['amount'] = round((float) ($data['amount'] ?? 0), 2);
        if ($data['amount'] <= 0) {
            throw new InvalidArgumentException(__('Fee amount must be greater than zero.'));
        }

        $data['academic_year'] = $data['academic_year'] ?? Qs::getCurrentSession();

        if (isset($data['is_taxable']) && $data['is_taxable']) {
            $data['tax_rate'] = round((float) ($data['tax_rate'] ?? 0), 2);
        } else {
            $data['is_taxable'] = false;
            $data['tax_rate'] = 0.00;
        }

        if (!empty($data['id'])) {
            $structure = FeeStructure::findOrFail($data['id']);
            $structure->update($data);
            return $structure;
        }

        return FeeStructure::create($data);
    }

    /**
     * Generate an Invoice with line items and record ledger entry inside a DB transaction.
     *
     * @param array $invoiceData
     * @param array $items
     * @return Invoice
     */
    public function generateInvoice(array $invoiceData, array $items)
    {
        if (empty($items)) {
            throw new InvalidArgumentException(__('Invoice must contain at least one line item.'));
        }

        // Duplicate submission protection
        if (!empty($invoiceData['idempotency_token'])) {
            $existing = Invoice::where('idempotency_token', $invoiceData['idempotency_token'])->first();
            if ($existing) {
                return $existing;
            }
        }

        return DB::transaction(function () use ($invoiceData, $items) {
            $academicYear = $invoiceData['academic_year'] ?? Qs::getCurrentSession();
            $invoiceNo = $invoiceData['invoice_no'] ?? $this->generateInvoiceNumber($academicYear);

            $invDate = $this->resolveDates(
                $invoiceData['invoice_date'] ?? null,
                !empty($invoiceData['is_date_bs'])
            );

            $dueDate = $this->resolveDates(
                $invoiceData['due_date'] ?? null,
                !empty($invoiceData['is_due_date_bs'])
            );

            $subtotal = 0.00;
            $totalDiscount = 0.00;
            $totalTaxable = 0.00;
            $totalTax = 0.00;
            $processedItems = [];

            foreach ($items as $item) {
                $unitPrice = round((float) ($item['unit_price'] ?? 0), 2);
                $qty = (float) ($item['quantity'] ?? 1.00);
                if ($qty <= 0) $qty = 1.00;
                $gross = round($unitPrice * $qty, 2);

                $discount = round((float) ($item['discount_amount'] ?? 0), 2);
                if ($discount > $gross) $discount = $gross;
                if ($discount < 0) $discount = 0.00;

                $afterDiscount = round($gross - $discount, 2);

                $taxRate = round((float) ($item['tax_rate'] ?? 0), 2);
                $taxAmount = 0.00;
                $taxableAmount = 0.00;

                if (!empty($item['is_taxable']) && $taxRate > 0) {
                    $taxableAmount = $afterDiscount;
                    $taxAmount = round(($taxableAmount * $taxRate) / 100, 2);
                }

                $netAmount = round($afterDiscount + $taxAmount, 2);

                $subtotal += $gross;
                $totalDiscount += $discount;
                $totalTaxable += $taxableAmount;
                $totalTax += $taxAmount;

                $processedItems[] = [
                    'fee_category_id' => $item['fee_category_id'] ?? null,
                    'fee_structure_id' => $item['fee_structure_id'] ?? null,
                    'title' => $item['title'] ?? 'Fee Item',
                    'description' => $item['description'] ?? null,
                    'unit_price' => $unitPrice,
                    'quantity' => $qty,
                    'gross_amount' => $gross,
                    'discount_amount' => $discount,
                    'taxable_amount' => $taxableAmount,
                    'tax_rate' => $taxRate,
                    'tax_amount' => $taxAmount,
                    'net_amount' => $netAmount,
                ];
            }

            // Overall invoice-level discount if specified
            $invoiceLevelDiscount = round((float) ($invoiceData['discount_amount'] ?? 0), 2);
            $totalDiscount += $invoiceLevelDiscount;

            $netTotal = round($subtotal - $totalDiscount + $totalTax, 2);
            if ($netTotal < 0) $netTotal = 0.00;

            $invoice = Invoice::create([
                'invoice_no' => $invoiceNo,
                'student_id' => $invoiceData['student_id'],
                'my_class_id' => $invoiceData['my_class_id'],
                'section_id' => $invoiceData['section_id'] ?? null,
                'academic_year' => $academicYear,
                'fee_period' => $invoiceData['fee_period'] ?? null,
                'invoice_date' => $invDate['ad'],
                'invoice_date_bs' => $invDate['bs'],
                'due_date' => $dueDate['ad'],
                'due_date_bs' => $dueDate['bs'],
                'subtotal' => $subtotal,
                'discount_amount' => $totalDiscount,
                'taxable_amount' => $totalTaxable,
                'tax_amount' => $totalTax,
                'net_total' => $netTotal,
                'paid_amount' => 0.00,
                'balance' => $netTotal,
                'status' => 'unpaid',
                'notes' => $invoiceData['notes'] ?? null,
                'created_by' => $invoiceData['created_by'] ?? auth()->id() ?? 1,
                'idempotency_token' => $invoiceData['idempotency_token'] ?? null,
                'legacy_pr_id' => $invoiceData['legacy_pr_id'] ?? null,
            ]);

            foreach ($processedItems as $pItem) {
                $pItem['invoice_id'] = $invoice->id;
                InvoiceItem::create($pItem);
            }

            // Record Debit in Student Fee Ledger
            $this->addLedgerEntry([
                'student_id' => $invoice->student_id,
                'academic_year' => $invoice->academic_year,
                'entry_type' => 'invoice',
                'entry_date' => $invoice->invoice_date,
                'entry_date_bs' => $invoice->invoice_date_bs,
                'reference_no' => $invoice->invoice_no,
                'debit' => $invoice->net_total,
                'credit' => 0.00,
                'source_type' => Invoice::class,
                'source_id' => $invoice->id,
                'description' => "Invoice generated: {$invoice->invoice_no} ({$invoice->fee_period})",
                'authorized_by' => $invoice->created_by,
            ]);

            return $invoice;
        });
    }

    /**
     * Record a Payment and issue Receipt inside a DB transaction.
     *
     * @param array $paymentData
     * @return FeePayment
     */
    public function recordPayment(array $paymentData)
    {
        $amount = round((float) ($paymentData['amount'] ?? 0), 2);
        if ($amount <= 0) {
            throw new InvalidArgumentException(__('Payment amount must be greater than zero.'));
        }

        // Duplicate submission protection
        if (!empty($paymentData['idempotency_token'])) {
            $existing = FeePayment::where('idempotency_token', $paymentData['idempotency_token'])->first();
            if ($existing) {
                return $existing;
            }
        }

        return DB::transaction(function () use ($paymentData, $amount) {
            $academicYear = $paymentData['academic_year'] ?? Qs::getCurrentSession();
            $receiptNo = $paymentData['receipt_no'] ?? $this->generateReceiptNumber($academicYear);

            $payDate = $this->resolveDates(
                $paymentData['payment_date'] ?? null,
                !empty($paymentData['is_date_bs'])
            );

            $studentId = $paymentData['student_id'];
            $invoiceId = $paymentData['invoice_id'] ?? null;

            // If an invoice is specified, validate and allocate
            $invoice = null;
            if ($invoiceId) {
                $invoice = Invoice::where('id', $invoiceId)
                    ->where('student_id', $studentId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($amount > $invoice->balance) {
                    throw new InvalidArgumentException(
                        __('Payment amount (:amt) cannot exceed outstanding invoice balance (:bal).', [
                            'amt' => NepaliHelper::formatNpr($amount),
                            'bal' => NepaliHelper::formatNpr($invoice->balance),
                        ])
                    );
                }
            }

            $feePayment = FeePayment::create([
                'receipt_no' => $receiptNo,
                'invoice_id' => $invoiceId,
                'student_id' => $studentId,
                'amount' => $amount,
                'payment_method' => $paymentData['payment_method'] ?? 'cash',
                'transaction_reference' => $paymentData['transaction_reference'] ?? null,
                'payment_date' => $payDate['ad'],
                'payment_date_bs' => $payDate['bs'],
                'academic_year' => $academicYear,
                'received_by' => $paymentData['received_by'] ?? auth()->id() ?? 1,
                'notes' => $paymentData['notes'] ?? null,
                'status' => 'completed',
                'idempotency_token' => $paymentData['idempotency_token'] ?? null,
                'legacy_pr_id' => $paymentData['legacy_pr_id'] ?? null,
            ]);

            // If allocated to invoice
            if ($invoice) {
                FeePaymentAllocation::create([
                    'fee_payment_id' => $feePayment->id,
                    'invoice_id' => $invoice->id,
                    'allocated_amount' => $amount,
                ]);

                $newPaid = round($invoice->paid_amount + $amount, 2);
                $newBalance = round(max(0, $invoice->net_total - $newPaid), 2);
                $newStatus = ($newBalance <= 0) ? 'paid' : 'partially_paid';

                $invoice->update([
                    'paid_amount' => $newPaid,
                    'balance' => $newBalance,
                    'status' => $newStatus,
                ]);
            }

            // Record Credit in Student Fee Ledger
            $desc = "Fee Payment received: {$feePayment->receipt_no} [{$feePayment->payment_method}]";
            if ($invoice) {
                $desc .= " for Invoice {$invoice->invoice_no}";
            }

            $this->addLedgerEntry([
                'student_id' => $studentId,
                'academic_year' => $academicYear,
                'entry_type' => 'payment',
                'entry_date' => $feePayment->payment_date,
                'entry_date_bs' => $feePayment->payment_date_bs,
                'reference_no' => $feePayment->receipt_no,
                'debit' => 0.00,
                'credit' => $amount,
                'source_type' => FeePayment::class,
                'source_id' => $feePayment->id,
                'description' => $desc,
                'authorized_by' => $feePayment->received_by,
            ]);

            return $feePayment;
        });
    }

    /**
     * Apply Authorized Fee Adjustment (Discount, Waiver, Scholarship, Refund, Correction).
     *
     * @param array $adjustmentData
     * @return FeeAdjustment
     */
    public function applyAdjustment(array $adjustmentData)
    {
        $amount = round((float) ($adjustmentData['amount'] ?? 0), 2);
        if ($amount <= 0) {
            throw new InvalidArgumentException(__('Adjustment amount must be greater than zero.'));
        }

        if (empty($adjustmentData['reason'])) {
            throw new InvalidArgumentException(__('A documented reason is mandatory for any adjustment or refund.'));
        }

        $type = $adjustmentData['adjustment_type'] ?? 'discount';
        if (!in_array($type, ['discount', 'waiver', 'scholarship', 'refund', 'correction'])) {
            throw new InvalidArgumentException(__('Invalid adjustment type.'));
        }

        // Duplicate submission protection
        if (!empty($adjustmentData['idempotency_token'])) {
            $existing = FeeAdjustment::where('idempotency_token', $adjustmentData['idempotency_token'])->first();
            if ($existing) {
                return $existing;
            }
        }

        return DB::transaction(function () use ($adjustmentData, $amount, $type) {
            $academicYear = $adjustmentData['academic_year'] ?? Qs::getCurrentSession();
            $adjNo = $adjustmentData['adjustment_no'] ?? $this->generateAdjustmentNumber($academicYear, $type);

            $adjDate = $this->resolveDates(
                $adjustmentData['adjustment_date'] ?? null,
                !empty($adjustmentData['is_date_bs'])
            );

            $studentId = $adjustmentData['student_id'];
            $invoiceId = $adjustmentData['invoice_id'] ?? null;
            $paymentId = $adjustmentData['fee_payment_id'] ?? null;
            $authorizedBy = $adjustmentData['authorized_by'] ?? auth()->id() ?? 1;

            if ($type === 'refund') {
                if (!$paymentId) {
                    throw new InvalidArgumentException(__('A specific payment record is required to issue a refund.'));
                }

                $payment = FeePayment::where('id', $paymentId)
                    ->where('student_id', $studentId)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Compute total already refunded for this payment
                $alreadyRefunded = (float) FeeAdjustment::where('fee_payment_id', $payment->id)
                    ->where('adjustment_type', 'refund')
                    ->sum('amount');

                $refundable = round($payment->amount - $alreadyRefunded, 2);
                if ($amount > $refundable) {
                    throw new InvalidArgumentException(
                        __('Refund amount (:req) exceeds maximum refundable amount (:max).', [
                            'req' => NepaliHelper::formatNpr($amount),
                            'max' => NepaliHelper::formatNpr($refundable),
                        ])
                    );
                }

                // If payment was linked to an invoice, re-adjust invoice balance
                if ($payment->invoice_id) {
                    $inv = Invoice::find($payment->invoice_id);
                    if ($inv) {
                        $invPaid = max(0, round($inv->paid_amount - $amount, 2));
                        $invBal = round($inv->net_total - $invPaid, 2);
                        $invStatus = ($invBal >= $inv->net_total) ? 'unpaid' : 'partially_paid';
                        $inv->update([
                            'paid_amount' => $invPaid,
                            'balance' => $invBal,
                            'status' => $invStatus,
                        ]);
                    }
                }

                $newTotalRefunded = round($alreadyRefunded + $amount, 2);
                $paymentStatus = ($newTotalRefunded >= $payment->amount) ? 'refunded' : 'partially_refunded';
                $payment->update(['status' => $paymentStatus]);

                // Create Adjustment Record
                $adjustment = FeeAdjustment::create([
                    'adjustment_no' => $adjNo,
                    'student_id' => $studentId,
                    'invoice_id' => $payment->invoice_id,
                    'fee_payment_id' => $payment->id,
                    'adjustment_type' => 'refund',
                    'amount' => $amount,
                    'reason' => $adjustmentData['reason'],
                    'authorized_by' => $authorizedBy,
                    'academic_year' => $academicYear,
                    'adjustment_date' => $adjDate['ad'],
                    'adjustment_date_bs' => $adjDate['bs'],
                    'idempotency_token' => $adjustmentData['idempotency_token'] ?? null,
                ]);

                // Record Debit in Student Fee Ledger (money returned to student reduces credit)
                $this->addLedgerEntry([
                    'student_id' => $studentId,
                    'academic_year' => $academicYear,
                    'entry_type' => 'refund',
                    'entry_date' => $adjustment->adjustment_date,
                    'entry_date_bs' => $adjustment->adjustment_date_bs,
                    'reference_no' => $adjustment->adjustment_no,
                    'debit' => $amount,
                    'credit' => 0.00,
                    'source_type' => FeeAdjustment::class,
                    'source_id' => $adjustment->id,
                    'description' => "Authorized Refund: {$adjustment->adjustment_no} for Payment {$payment->receipt_no}. Reason: {$adjustment->reason}",
                    'authorized_by' => $authorizedBy,
                ]);

                return $adjustment;
            }

            // Non-refund adjustment (discount, waiver, scholarship, correction)
            $invoice = null;
            if ($invoiceId) {
                $invoice = Invoice::where('id', $invoiceId)
                    ->where('student_id', $studentId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($amount > $invoice->balance) {
                    throw new InvalidArgumentException(
                        __('Discount/waiver amount (:amt) cannot exceed outstanding invoice balance (:bal).', [
                            'amt' => NepaliHelper::formatNpr($amount),
                            'bal' => NepaliHelper::formatNpr($invoice->balance),
                        ])
                    );
                }

                $newDiscount = round($invoice->discount_amount + $amount, 2);
                $newNet = round(max(0, $invoice->net_total - $amount), 2);
                $newBal = round(max(0, $invoice->balance - $amount), 2);
                $newStatus = ($newBal <= 0) ? 'paid' : ($invoice->paid_amount > 0 ? 'partially_paid' : 'unpaid');

                $invoice->update([
                    'discount_amount' => $newDiscount,
                    'net_total' => $newNet,
                    'balance' => $newBal,
                    'status' => $newStatus,
                ]);
            }

            $adjustment = FeeAdjustment::create([
                'adjustment_no' => $adjNo,
                'student_id' => $studentId,
                'invoice_id' => $invoiceId,
                'fee_payment_id' => null,
                'adjustment_type' => $type,
                'amount' => $amount,
                'reason' => $adjustmentData['reason'],
                'authorized_by' => $authorizedBy,
                'academic_year' => $academicYear,
                'adjustment_date' => $adjDate['ad'],
                'adjustment_date_bs' => $adjDate['bs'],
                'idempotency_token' => $adjustmentData['idempotency_token'] ?? null,
            ]);

            // Record Credit in Student Fee Ledger (reduces student dues)
            $desc = "Authorized {$type}: {$adjustment->adjustment_no}. Reason: {$adjustment->reason}";
            if ($invoice) {
                $desc .= " (Applied to Invoice {$invoice->invoice_no})";
            }

            $this->addLedgerEntry([
                'student_id' => $studentId,
                'academic_year' => $academicYear,
                'entry_type' => 'discount_waiver',
                'entry_date' => $adjustment->adjustment_date,
                'entry_date_bs' => $adjustment->adjustment_date_bs,
                'reference_no' => $adjustment->adjustment_no,
                'debit' => 0.00,
                'credit' => $amount,
                'source_type' => FeeAdjustment::class,
                'source_id' => $adjustment->id,
                'description' => $desc,
                'authorized_by' => $authorizedBy,
            ]);

            return $adjustment;
        });
    }

    /**
     * Add an entry to the student ledger and update the running balance.
     *
     * @param array $entryData
     * @return StudentLedgerEntry
     */
    public function addLedgerEntry(array $entryData)
    {
        $studentId = $entryData['student_id'];
        $debit = round((float) ($entryData['debit'] ?? 0), 2);
        $credit = round((float) ($entryData['credit'] ?? 0), 2);

        // Calculate latest running balance
        $latest = StudentLedgerEntry::where('student_id', $studentId)
            ->orderBy('id', 'desc')
            ->first();

        $previousBalance = $latest ? (float) $latest->running_balance : 0.00;
        $runningBalance = round($previousBalance + $debit - $credit, 2);

        $entryData['debit'] = $debit;
        $entryData['credit'] = $credit;
        $entryData['running_balance'] = $runningBalance;

        return StudentLedgerEntry::create($entryData);
    }

    /**
     * Get complete Student Fee Ledger with summary.
     *
     * @param int $studentId
     * @param string|null $academicYear
     * @return array
     */
    public function getStudentLedger($studentId, $academicYear = null)
    {
        $student = User::with('student_record.my_class', 'student_record.section')->findOrFail($studentId);

        $query = StudentLedgerEntry::where('student_id', $studentId)
            ->with('authorizer');

        if ($academicYear) {
            $query->where('academic_year', $academicYear);
        }

        $entries = $query->orderBy('entry_date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $totalDebit = 0.00;
        $totalCredit = 0.00;
        $running = 0.00;

        foreach ($entries as $e) {
            $totalDebit += (float) $e->debit;
            $totalCredit += (float) $e->credit;
            $running = round($running + (float) $e->debit - (float) $e->credit, 2);
            $e->computed_running_balance = $running;
        }

        $netOutstanding = round($totalDebit - $totalCredit, 2);

        // Fetch associated active invoices
        $invQuery = Invoice::where('student_id', $studentId)
            ->with('items.category');
        if ($academicYear) {
            $invQuery->where('academic_year', $academicYear);
        }
        $invoices = $invQuery->orderBy('invoice_date', 'desc')->get();

        // Fetch associated payments
        $payQuery = FeePayment::where('student_id', $studentId);
        if ($academicYear) {
            $payQuery->where('academic_year', $academicYear);
        }
        $payments = $payQuery->orderBy('payment_date', 'desc')->get();

        return [
            'student' => $student,
            'academic_year' => $academicYear ?: Qs::getCurrentSession(),
            'entries' => $entries,
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
            'net_outstanding' => $netOutstanding,
            'is_credit_balance' => ($netOutstanding < 0),
            'credit_balance' => ($netOutstanding < 0) ? abs($netOutstanding) : 0.00,
            'invoices' => $invoices,
            'payments' => $payments,
        ];
    }

    /**
     * Generate Comprehensive Financial Reports.
     *
     * @param array $filters
     * @return array
     */
    public function getFinancialReports(array $filters = [])
    {
        $academicYear = $filters['academic_year'] ?? Qs::getCurrentSession();

        // 1. Daily Collection Report
        $dailyQuery = FeePayment::where('status', '!=', 'cancelled')
            ->where('academic_year', $academicYear);

        if (!empty($filters['date_from'])) {
            $dFrom = $this->resolveDates($filters['date_from'], !empty($filters['is_bs']));
            $dailyQuery->where('payment_date', '>=', $dFrom['ad']);
        }
        if (!empty($filters['date_to'])) {
            $dTo = $this->resolveDates($filters['date_to'], !empty($filters['is_bs']));
            $dailyQuery->where('payment_date', '<=', $dTo['ad']);
        }

        $payments = $dailyQuery->with('student', 'receiver', 'invoice')->orderBy('payment_date', 'desc')->get();

        $dailyCollection = $payments->groupBy('payment_date')->map(function ($dayPayments, $date) {
            $bsDate = $dayPayments->first()->payment_date_bs;
            $cash = $dayPayments->where('payment_method', 'cash')->sum('amount');
            $bank = $dayPayments->where('payment_method', 'bank_transfer')->sum('amount');
            $digital = $dayPayments->whereIn('payment_method', ['esewa', 'khalti'])->sum('amount');
            $cheque = $dayPayments->where('payment_method', 'cheque')->sum('amount');
            $other = $dayPayments->where('payment_method', 'other')->sum('amount');
            $total = $dayPayments->sum('amount');

            return [
                'date_ad' => $date,
                'date_bs' => $bsDate,
                'count' => $dayPayments->count(),
                'cash' => $cash,
                'bank' => $bank,
                'digital' => $digital,
                'cheque' => $cheque,
                'other' => $other,
                'total' => $total,
            ];
        })->values();

        // Payment Method breakdown
        $paymentMethodsSummary = [
            'cash' => (float) $payments->where('payment_method', 'cash')->sum('amount'),
            'bank_transfer' => (float) $payments->where('payment_method', 'bank_transfer')->sum('amount'),
            'esewa' => (float) $payments->where('payment_method', 'esewa')->sum('amount'),
            'khalti' => (float) $payments->where('payment_method', 'khalti')->sum('amount'),
            'cheque' => (float) $payments->where('payment_method', 'cheque')->sum('amount'),
            'other' => (float) $payments->where('payment_method', 'other')->sum('amount'),
            'total' => (float) $payments->sum('amount'),
        ];

        // 2. Class-wise Collection Report
        $classes = MyClass::orderBy('name')->get();
        $classCollection = [];

        foreach ($classes as $cls) {
            $invoices = Invoice::where('my_class_id', $cls->id)
                ->where('academic_year', $academicYear)
                ->where('status', '!=', 'cancelled')
                ->get();

            $totalBilled = (float) $invoices->sum('net_total');
            $totalPaid = (float) $invoices->sum('paid_amount');
            $totalOutstanding = (float) $invoices->sum('balance');
            $pct = $totalBilled > 0 ? round(($totalPaid / $totalBilled) * 100, 1) : 0;

            $classCollection[] = [
                'class_id' => $cls->id,
                'class_name' => $cls->name,
                'invoice_count' => $invoices->count(),
                'total_billed' => $totalBilled,
                'total_paid' => $totalPaid,
                'total_outstanding' => $totalOutstanding,
                'collection_percentage' => $pct,
            ];
        }

        // 3. Outstanding Invoices Report
        $outstandingQuery = Invoice::where('academic_year', $academicYear)
            ->whereIn('status', ['unpaid', 'partially_paid'])
            ->with('student', 'my_class', 'section');

        if (!empty($filters['my_class_id'])) {
            $outstandingQuery->where('my_class_id', $filters['my_class_id']);
        }

        $outstandingInvoices = $outstandingQuery->orderBy('due_date', 'asc')->get();

        // 4. Discounts & Waivers Summary
        $adjustmentsQuery = FeeAdjustment::where('academic_year', $academicYear)
            ->with('student', 'authorizer');
        $allAdjustments = $adjustmentsQuery->orderBy('adjustment_date', 'desc')->get();

        $discountsSummary = [
            'total_discounts' => (float) $allAdjustments->where('adjustment_type', 'discount')->sum('amount'),
            'total_waivers' => (float) $allAdjustments->where('adjustment_type', 'waiver')->sum('amount'),
            'total_scholarships' => (float) $allAdjustments->where('adjustment_type', 'scholarship')->sum('amount'),
            'total_refunds' => (float) $allAdjustments->where('adjustment_type', 'refund')->sum('amount'),
            'total_adjustments_count' => $allAdjustments->count(),
            'records' => $allAdjustments,
        ];

        return [
            'academic_year' => $academicYear,
            'daily_collection' => $dailyCollection,
            'payment_methods' => $paymentMethodsSummary,
            'class_collection' => $classCollection,
            'outstanding_invoices' => $outstandingInvoices,
            'discounts_summary' => $discountsSummary,
            'total_revenue_collected' => (float) $payments->sum('amount'),
        ];
    }
}
