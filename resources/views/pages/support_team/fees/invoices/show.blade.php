@extends('layouts.master')
@section('page_title', __('Invoice') . ' - ' . $invoice->invoice_no)
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-bold">
                <i class="icon-file-text mr-2 text-primary"></i> {{ __('Invoice') }}: <span class="text-primary">{{ $invoice->invoice_no }}</span>
                @if($invoice->status === 'paid')
                    <span class="badge badge-success ml-2">{{ __('PAID') }}</span>
                @elseif($invoice->status === 'partially_paid')
                    <span class="badge badge-warning ml-2">{{ __('PARTIALLY PAID') }}</span>
                @elseif($invoice->status === 'cancelled')
                    <span class="badge badge-danger ml-2">{{ __('CANCELLED') }}</span>
                @else
                    <span class="badge badge-danger ml-2">{{ __('UNPAID') }}</span>
                @endif
            </h5>
            <div class="header-elements">
                <a href="{{ route('fees.invoices.print', $invoice->id) }}" target="_blank" class="btn btn-outline-primary btn-sm mr-2">
                    <i class="icon-printer mr-1"></i> {{ __('Print Invoice') }}
                </a>
                @if($invoice->balance > 0 && Qs::userIsTeamAccount())
                    <a href="{{ route('fees.payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-success btn-sm mr-2">
                        <i class="icon-cash mr-1"></i> {{ __('Record Payment') }}
                    </a>
                    <a href="{{ route('fees.adjustments.create', ['student_id' => $invoice->student_id, 'invoice_id' => $invoice->id]) }}" class="btn btn-outline-warning btn-sm">
                        <i class="icon-shield-check mr-1"></i> {{ __('Apply Waiver/Discount') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            {{-- Student & Invoice Meta Info --}}
            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border h-100">
                        <h6 class="font-weight-bold text-dark border-bottom pb-2">{{ __('Billed Student Information') }}</h6>
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <th class="p-1 text-muted" style="width: 140px;">{{ __('Student Name') }}:</th>
                                <td class="p-1 font-weight-bold">{{ $invoice->student->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="p-1 text-muted">{{ __('Admission No') }}:</th>
                                <td class="p-1">{{ $invoice->student->student_record->adm_no ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="p-1 text-muted">{{ __('Class & Section') }}:</th>
                                <td class="p-1">{{ $invoice->my_class->name ?? '-' }} {{ $invoice->section ? '('.$invoice->section->name.')' : '' }}</td>
                            </tr>
                            <tr>
                                <th class="p-1 text-muted">{{ __('Academic Year') }}:</th>
                                <td class="p-1"><span class="badge badge-info">{{ $invoice->academic_year }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border h-100">
                        <h6 class="font-weight-bold text-dark border-bottom pb-2">{{ __('Invoice Metadata') }}</h6>
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <th class="p-1 text-muted" style="width: 140px;">{{ __('Invoice Number') }}:</th>
                                <td class="p-1 font-weight-bold text-primary">{{ $invoice->invoice_no }}</td>
                            </tr>
                            <tr>
                                <th class="p-1 text-muted">{{ __('Billing Period') }}:</th>
                                <td class="p-1 font-weight-semibold">{{ $invoice->fee_period ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="p-1 text-muted">{{ __('Invoice Date') }}:</th>
                                <td class="p-1">{{ $invoice->invoice_date_bs }} (AD: {{ $invoice->invoice_date->format('Y-m-d') }})</td>
                            </tr>
                            <tr>
                                <th class="p-1 text-muted">{{ __('Due Date') }}:</th>
                                <td class="p-1 text-danger font-weight-semibold">{{ $invoice->due_date_bs }} (AD: {{ $invoice->due_date->format('Y-m-d') }})</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Line Items Table --}}
            <h6 class="font-weight-bold mb-2">{{ __('Invoice Particulars / Line Items') }}</h6>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('Item Description') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th class="text-right">{{ __('Rate (रु)') }}</th>
                        <th class="text-center">{{ __('Qty') }}</th>
                        <th class="text-right">{{ __('Gross (रु)') }}</th>
                        <th class="text-right">{{ __('Discount (रु)') }}</th>
                        <th class="text-right">{{ __('Tax/VAT') }}</th>
                        <th class="text-right">{{ __('Net Amount (रु)') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-weight-semibold">{{ $item->title }}</td>
                            <td><span class="badge badge-light border">{{ $item->category->name ?? 'General' }}</span></td>
                            <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($item->unit_price) }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($item->gross_amount) }}</td>
                            <td class="text-right text-muted">{{ App\Helpers\NepaliHelper::formatNpr($item->discount_amount) }}</td>
                            <td class="text-right">
                                @if($item->tax_amount > 0)
                                    {{ App\Helpers\NepaliHelper::formatNpr($item->tax_amount) }} <small class="text-muted">({{ $item->tax_rate }}%)</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-right font-weight-bold">{{ App\Helpers\NepaliHelper::formatNpr($item->net_amount) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Financial Summary Box --}}
            <div class="row justify-content-end mb-4">
                <div class="col-md-5">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="text-muted">{{ __('Subtotal (Gross)') }}:</th>
                                <td class="text-right font-weight-semibold">{{ App\Helpers\NepaliHelper::formatNpr($invoice->subtotal) }}</td>
                            </tr>
                            @if($invoice->discount_amount > 0)
                                <tr>
                                    <th class="text-muted">{{ __('Total Discounts & Waivers') }}:</th>
                                    <td class="text-right text-success">- {{ App\Helpers\NepaliHelper::formatNpr($invoice->discount_amount) }}</td>
                                </tr>
                            @endif
                            @if($invoice->tax_amount > 0)
                                <tr>
                                    <th class="text-muted">{{ __('Applicable Taxes / VAT') }}:</th>
                                    <td class="text-right text-muted">+ {{ App\Helpers\NepaliHelper::formatNpr($invoice->tax_amount) }}</td>
                                </tr>
                            @endif
                            <tr class="bg-light">
                                <th class="h6 font-weight-bold text-dark">{{ __('Net Invoice Total') }}:</th>
                                <td class="text-right h6 font-weight-bold text-dark">{{ App\Helpers\NepaliHelper::formatNpr($invoice->net_total) }}</td>
                            </tr>
                            <tr>
                                <th class="text-success">{{ __('Total Paid to Date') }}:</th>
                                <td class="text-right font-weight-bold text-success">{{ App\Helpers\NepaliHelper::formatNpr($invoice->paid_amount) }}</td>
                            </tr>
                            <tr class="{{ $invoice->balance > 0 ? 'bg-warning-light text-danger' : 'bg-success-light text-success' }}">
                                <th class="h5 font-weight-bold">{{ __('Outstanding Balance Due') }}:</th>
                                <td class="text-right h5 font-weight-bold">{{ App\Helpers\NepaliHelper::formatNpr($invoice->balance) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Payment Receipts against this invoice --}}
            @if($invoice->payments->count())
                <h6 class="font-weight-bold mb-2"><i class="icon-cash mr-1 text-success"></i> {{ __('Payments Recorded on this Invoice') }}</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-striped table-sm">
                        <thead class="bg-light">
                        <tr>
                            <th>{{ __('Receipt #') }}</th>
                            <th>{{ __('Date (BS)') }}</th>
                            <th>{{ __('Method') }}</th>
                            <th>{{ __('Transaction Ref') }}</th>
                            <th class="text-right">{{ __('Amount Paid') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->payments as $p)
                            <tr>
                                <td class="font-weight-bold text-primary">{{ $p->receipt_no }}</td>
                                <td>{{ $p->payment_date_bs }}</td>
                                <td><span class="badge badge-light border">{{ strtoupper($p->payment_method) }}</span></td>
                                <td>{{ $p->transaction_reference ?: '-' }}</td>
                                <td class="text-right font-weight-bold text-success">{{ App\Helpers\NepaliHelper::formatNpr($p->amount) }}</td>
                                <td>
                                    <a href="{{ route('fees.receipts.show', $p->id) }}" class="btn btn-sm btn-outline-primary py-0">
                                        <i class="icon-eye mr-1"></i> {{ __('Receipt') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($invoice->notes)
                <div class="alert alert-secondary py-2">
                    <span class="font-weight-bold">{{ __('Notes / Remarks') }}:</span> {{ $invoice->notes }}
                </div>
            @endif
        </div>
    </div>

@endsection
