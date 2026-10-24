@extends('layouts.master')
@section('page_title', __('Payment Receipt') . ' - ' . $payment->receipt_no)
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-bold">
                <i class="icon-receipt mr-2 text-success"></i> {{ __('Official Payment Receipt') }}: <span class="text-primary">{{ $payment->receipt_no }}</span>
                @if($payment->status === 'completed')
                    <span class="badge badge-success ml-2">{{ __('SUCCESS') }}</span>
                @elseif($payment->status === 'refunded')
                    <span class="badge badge-danger ml-2">{{ __('REFUNDED') }}</span>
                @elseif($payment->status === 'partially_refunded')
                    <span class="badge badge-warning ml-2">{{ __('PARTIALLY REFUNDED') }}</span>
                @endif
            </h5>
            <div class="header-elements">
                <a href="{{ route('fees.receipts.print', $payment->id) }}" target="_blank" class="btn btn-outline-primary btn-sm mr-2">
                    <i class="icon-printer mr-1"></i> {{ __('Print Receipt') }}
                </a>
                <a href="{{ route('fees.ledger.show', $payment->student_id) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="icon-history mr-1"></i> {{ __('Student Ledger') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="p-4 bg-light rounded border mb-4 text-center">
                <div class="text-muted small text-uppercase font-weight-bold">{{ __('Total Amount Received') }}</div>
                <div class="display-4 font-weight-bold text-success my-2">
                    {{ App\Helpers\NepaliHelper::formatNpr($payment->amount) }}
                </div>
                <div class="badge badge-primary px-3 py-1 font-weight-semibold text-uppercase">
                    {{ __('Paid via') }}: {{ $payment->payment_method }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="p-3 border rounded h-100">
                        <h6 class="font-weight-bold border-bottom pb-2 text-dark">{{ __('Student Details') }}</h6>
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <th class="text-muted" style="width: 140px;">{{ __('Name') }}:</th>
                                <td class="font-weight-bold">{{ $payment->student->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">{{ __('Admission No') }}:</th>
                                <td>{{ $payment->student->student_record->adm_no ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">{{ __('Class') }}:</th>
                                <td>{{ $payment->student->student_record->my_class->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">{{ __('Academic Year') }}:</th>
                                <td><span class="badge badge-info">{{ $payment->academic_year }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="p-3 border rounded h-100">
                        <h6 class="font-weight-bold border-bottom pb-2 text-dark">{{ __('Transaction Information') }}</h6>
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <th class="text-muted" style="width: 140px;">{{ __('Receipt No') }}:</th>
                                <td class="font-weight-bold text-primary">{{ $payment->receipt_no }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">{{ __('Payment Date') }}:</th>
                                <td>{{ $payment->payment_date_bs }} BS (AD: {{ $payment->payment_date->format('Y-m-d') }})</td>
                            </tr>
                            <tr>
                                <th class="text-muted">{{ __('Transaction Ref') }}:</th>
                                <td>{{ $payment->transaction_reference ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">{{ __('Cashier') }}:</th>
                                <td>{{ $payment->receiver->name ?? 'School Cashier' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            @if($payment->invoice)
                <div class="card border mt-3">
                    <div class="card-header bg-light py-2">
                        <h6 class="card-title font-weight-bold mb-0">
                            {{ __('Invoice Applied') }}: <a href="{{ route('fees.invoices.show', $payment->invoice->id) }}">{{ $payment->invoice->invoice_no }}</a> ({{ $payment->invoice->fee_period }})
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-sm-4 text-center">
                                <span class="text-muted small">{{ __('Invoice Total') }}:</span>
                                <div class="font-weight-bold">{{ App\Helpers\NepaliHelper::formatNpr($payment->invoice->net_total) }}</div>
                            </div>
                            <div class="col-sm-4 text-center border-left border-right">
                                <span class="text-muted small">{{ __('Total Paid') }}:</span>
                                <div class="font-weight-bold text-success">{{ App\Helpers\NepaliHelper::formatNpr($payment->invoice->paid_amount) }}</div>
                            </div>
                            <div class="col-sm-4 text-center">
                                <span class="text-muted small">{{ __('Remaining Balance') }}:</span>
                                <div class="font-weight-bold {{ $payment->invoice->balance > 0 ? 'text-danger' : 'text-muted' }}">
                                    {{ App\Helpers\NepaliHelper::formatNpr($payment->invoice->balance) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($payment->notes)
                <div class="alert alert-secondary py-2 mt-3">
                    <span class="font-weight-bold">{{ __('Remarks') }}:</span> {{ $payment->notes }}
                </div>
            @endif
        </div>
    </div>

@endsection
