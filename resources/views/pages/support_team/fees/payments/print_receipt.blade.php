<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Fee Receipt') }} - {{ $payment->receipt_no }}</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        body {
            background-color: #fff;
            color: #111;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 20px;
        }
        .receipt-container {
            max-width: 720px;
            margin: auto;
            padding: 25px;
            border: 2px dashed #444;
            border-radius: 4px;
            background: #fff;
        }
        .header-title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .receipt-badge {
            display: inline-block;
            background: #27ae60;
            color: #fff;
            padding: 4px 16px;
            font-weight: bold;
            font-size: 13px;
            border-radius: 3px;
            margin-top: 5px;
        }
        .amount-box {
            background: #f8f9fa;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 18px;
            font-weight: bold;
            color: #1e7e34;
            display: inline-block;
        }
        .sig-line {
            border-top: 1px dashed #333;
            width: 170px;
            margin-top: 45px;
            text-align: center;
            font-size: 11px;
            padding-top: 4px;
        }
        @media print {
            body { padding: 0; }
            .receipt-container { border: 1px solid #000; padding: 15px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="text-center no-print mb-3">
        <button onclick="window.print()" class="btn btn-success btn-sm px-4">
            {{ __('Print Receipt') }}
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm px-3 ml-2">
            {{ __('Close Window') }}
        </button>
    </div>

    <div class="receipt-container">
        {{-- Header --}}
        <div class="text-center pb-2 border-bottom">
            <div class="header-title">{{ $s['system_name'] ?? 'NEPAL MODEL SECONDARY SCHOOL' }}</div>
            <div class="small text-muted">{{ $s['address'] ?? 'Kathmandu, Nepal' }} | Tel: {{ $s['phone'] ?? '+977-1-4XXXXXX' }}</div>
            <div class="receipt-badge">{{ __('OFFICIAL FEE RECEIPT') }} / {{ __('आधिकारिक शुल्क रसिद') }}</div>
        </div>

        {{-- Meta Row --}}
        <div class="row pt-3 pb-2 border-bottom">
            <div class="col-6">
                <strong>{{ __('Receipt No') }}:</strong> <span class="text-primary font-weight-bold">{{ $payment->receipt_no }}</span>
            </div>
            <div class="col-6 text-right">
                <strong>{{ __('Date (BS)') }}:</strong> {{ $payment->payment_date_bs }}
                <span class="text-muted small ml-1">(AD: {{ $payment->payment_date->format('Y-m-d') }})</span>
            </div>
        </div>

        {{-- Details --}}
        <div class="pt-3 pb-2">
            <table class="table table-borderless table-sm mb-0" style="line-height: 1.8;">
                <tr>
                    <td class="text-muted font-weight-bold" style="width: 150px;">{{ __('Received From') }}:</td>
                    <td class="font-weight-bold h6 mb-0">{{ $payment->student->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="text-muted font-weight-bold">{{ __('Admission / Roll No') }}:</td>
                    <td>{{ $payment->student->student_record->adm_no ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-muted font-weight-bold">{{ __('Class & Section') }}:</td>
                    <td>{{ $payment->student->student_record->my_class->name ?? '-' }} {{ $payment->student->student_record->section ? '('.$payment->student->student_record->section->name.')' : '' }}</td>
                </tr>
                <tr>
                    <td class="text-muted font-weight-bold">{{ __('Payment Method') }}:</td>
                    <td>
                        <span class="text-uppercase font-weight-bold">{{ $payment->payment_method }}</span>
                        @if($payment->transaction_reference)
                            <span class="text-muted ml-2">({{ __('Ref') }}: {{ $payment->transaction_reference }})</span>
                        @endif
                    </td>
                </tr>
                @if($payment->invoice)
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Against Invoice') }}:</td>
                        <td>
                            {{ $payment->invoice->invoice_no }} ({{ $payment->invoice->fee_period }})
                            <span class="text-muted small ml-2">[Invoice Total: {{ App\Helpers\NepaliHelper::formatNpr($payment->invoice->net_total) }}, Balance: {{ App\Helpers\NepaliHelper::formatNpr($payment->invoice->balance) }}]</span>
                        </td>
                    </tr>
                @endif
                @if($payment->notes)
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Remarks') }}:</td>
                        <td>{{ $payment->notes }}</td>
                    </tr>
                @endif
            </table>
        </div>

        {{-- Amount Box --}}
        <div class="row pt-3 pb-2 border-top border-bottom align-items-center">
            <div class="col-sm-5">
                <span class="text-muted text-uppercase font-weight-bold small d-block">{{ __('Amount Paid') }}:</span>
                <div class="amount-box mt-1">
                    {{ App\Helpers\NepaliHelper::formatNpr($payment->amount) }}
                </div>
            </div>
            <div class="col-sm-7 text-sm-right mt-2 mt-sm-0">
                <span class="badge badge-success px-3 py-1 font-weight-bold text-uppercase">
                    <i class="icon-checkmark-circle mr-1"></i> {{ __('Payment Received in Full') }}
                </span>
            </div>
        </div>

        {{-- Signatures --}}
        <div class="row pt-4 mt-2">
            <div class="col-6">
                <div class="sig-line">{{ __('Depositor / Student Signature') }}</div>
            </div>
            <div class="col-6 text-right">
                <div class="sig-line float-right">
                    {{ $payment->receiver->name ?? 'Authorized Cashier' }}<br>
                    <span class="text-muted small">{{ __('Cashier / Account Department') }}</span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
