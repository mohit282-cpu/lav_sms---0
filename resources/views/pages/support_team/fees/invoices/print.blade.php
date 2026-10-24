<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Fee Invoice') }} - {{ $invoice->invoice_no }}</title>
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
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 25px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .header-title {
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .sub-header {
            font-size: 13px;
            color: #555;
        }
        .invoice-type {
            display: inline-block;
            background: #2c3e50;
            color: #fff;
            padding: 4px 14px;
            font-weight: bold;
            font-size: 14px;
            border-radius: 3px;
            margin-top: 5px;
        }
        .table-items th {
            background-color: #f7f9fa;
            border-bottom: 2px solid #ccc;
            font-size: 12px;
            text-transform: uppercase;
        }
        .signature-box {
            margin-top: 50px;
        }
        .sig-line {
            border-top: 1px dashed #333;
            width: 180px;
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            padding-top: 5px;
        }
        @media print {
            body { padding: 0; }
            .invoice-box { border: none; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="text-center no-print mb-3">
        <button onclick="window.print()" class="btn btn-primary btn-sm px-4">
            {{ __('Print Invoice') }}
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm px-3 ml-2">
            {{ __('Close Window') }}
        </button>
    </div>

    <div class="invoice-box">
        {{-- School Header --}}
        <div class="text-center pb-3 border-bottom">
            <div class="header-title">{{ $s['system_name'] ?? 'NEPAL MODEL SECONDARY SCHOOL' }}</div>
            <div class="sub-header">{{ $s['address'] ?? 'Kathmandu, Nepal' }} | Tel: {{ $s['phone'] ?? '+977-1-4XXXXXX' }}</div>
            <div class="invoice-type">{{ __('FEE INVOICE') }} / {{ __('शुल्क बिजक') }}</div>
        </div>

        {{-- Invoice & Student Meta Details --}}
        <div class="row pt-3 pb-2">
            <div class="col-7">
                <table class="table-sm table-borderless" style="line-height: 1.5;">
                    <tr>
                        <td class="text-muted font-weight-bold" style="width: 110px;">{{ __('Student Name') }}:</td>
                        <td class="font-weight-bold">{{ $invoice->student->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Admission No') }}:</td>
                        <td>{{ $invoice->student->student_record->adm_no ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Class & Section') }}:</td>
                        <td>{{ $invoice->my_class->name ?? '-' }} {{ $invoice->section ? '('.$invoice->section->name.')' : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Academic Year') }}:</td>
                        <td>{{ $invoice->academic_year }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-5 text-right">
                <table class="table-sm table-borderless float-right" style="line-height: 1.5;">
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Invoice No') }}:</td>
                        <td class="font-weight-bold text-dark">{{ $invoice->invoice_no }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Date (BS)') }}:</td>
                        <td>{{ $invoice->invoice_date_bs }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Date (AD)') }}:</td>
                        <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Due Date (BS)') }}:</td>
                        <td class="text-danger font-weight-bold">{{ $invoice->due_date_bs }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Fee Period') }}:</td>
                        <td>{{ $invoice->fee_period ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Line Items --}}
        <table class="table table-bordered table-sm table-items mt-2">
            <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>{{ __('Particulars / Fee Description') }}</th>
                <th class="text-right" style="width: 90px;">{{ __('Rate (रु)') }}</th>
                <th class="text-center" style="width: 50px;">{{ __('Qty') }}</th>
                <th class="text-right" style="width: 90px;">{{ __('Gross (रु)') }}</th>
                <th class="text-right" style="width: 90px;">{{ __('Discount') }}</th>
                <th class="text-right" style="width: 100px;">{{ __('Net (रु)') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        <span class="font-weight-semibold">{{ $item->title }}</span>
                        @if($item->description)
                            <br><small class="text-muted">{{ $item->description }}</small>
                        @endif
                    </td>
                    <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($item->unit_price) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($item->gross_amount) }}</td>
                    <td class="text-right">{{ $item->discount_amount > 0 ? App\Helpers\NepaliHelper::formatNpr($item->discount_amount) : '-' }}</td>
                    <td class="text-right font-weight-semibold">{{ App\Helpers\NepaliHelper::formatNpr($item->net_amount) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="row justify-content-end pt-2">
            <div class="col-5">
                <table class="table table-sm table-bordered">
                    <tr>
                        <td class="text-muted">{{ __('Subtotal') }}:</td>
                        <td class="text-right font-weight-semibold">{{ App\Helpers\NepaliHelper::formatNpr($invoice->subtotal) }}</td>
                    </tr>
                    @if($invoice->discount_amount > 0)
                        <tr>
                            <td class="text-muted">{{ __('Discounts & Waivers') }}:</td>
                            <td class="text-right text-success">- {{ App\Helpers\NepaliHelper::formatNpr($invoice->discount_amount) }}</td>
                        </tr>
                    @endif
                    @if($invoice->tax_amount > 0)
                        <tr>
                            <td class="text-muted">{{ __('Tax / VAT') }}:</td>
                            <td class="text-right">+ {{ App\Helpers\NepaliHelper::formatNpr($invoice->tax_amount) }}</td>
                        </tr>
                    @endif
                    <tr class="bg-light">
                        <td class="font-weight-bold">{{ __('Net Total') }}:</td>
                        <td class="text-right font-weight-bold">{{ App\Helpers\NepaliHelper::formatNpr($invoice->net_total) }}</td>
                    </tr>
                    <tr>
                        <td class="text-success">{{ __('Total Paid') }}:</td>
                        <td class="text-right font-weight-bold text-success">{{ App\Helpers\NepaliHelper::formatNpr($invoice->paid_amount) }}</td>
                    </tr>
                    <tr class="font-weight-bold text-danger">
                        <td>{{ __('Balance Payable') }}:</td>
                        <td class="text-right h6 mb-0">{{ App\Helpers\NepaliHelper::formatNpr($invoice->balance) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($invoice->notes)
            <div class="small text-muted border-top pt-2 mt-2">
                <strong>{{ __('Note') }}:</strong> {{ $invoice->notes }}
            </div>
        @endif

        {{-- Signatures --}}
        <div class="row signature-box pt-4">
            <div class="col-4">
                <div class="sig-line">{{ __('Student / Parent Signature') }}</div>
            </div>
            <div class="col-4 text-center">
                <div class="sig-line mx-auto">{{ __('Cashier / Accountant') }}</div>
            </div>
            <div class="col-4 text-right">
                <div class="sig-line float-right">{{ __('Principal / Authorized Seal') }}</div>
            </div>
        </div>
    </div>

</body>
</html>
