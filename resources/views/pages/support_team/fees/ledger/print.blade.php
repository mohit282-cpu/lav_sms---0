<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Fee Statement') }} - {{ $student->name }}</title>
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
        .statement-container {
            max-width: 850px;
            margin: auto;
            padding: 25px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .header-title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .statement-badge {
            display: inline-block;
            background: #2c3e50;
            color: #fff;
            padding: 3px 14px;
            font-weight: bold;
            font-size: 13px;
            border-radius: 3px;
            margin-top: 5px;
        }
        .table-ledger th {
            background-color: #f7f9fa;
            border-bottom: 2px solid #ccc;
            font-size: 12px;
            text-transform: uppercase;
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
            .statement-container { border: none; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="text-center no-print mb-3">
        <button onclick="window.print()" class="btn btn-primary btn-sm px-4">
            {{ __('Print Statement') }}
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm px-3 ml-2">
            {{ __('Close Window') }}
        </button>
    </div>

    <div class="statement-container">
        {{-- Header --}}
        <div class="text-center pb-2 border-bottom">
            <div class="header-title">{{ $s['system_name'] ?? 'NEPAL MODEL SECONDARY SCHOOL' }}</div>
            <div class="small text-muted">{{ $s['address'] ?? 'Kathmandu, Nepal' }} | Tel: {{ $s['phone'] ?? '+977-1-4XXXXXX' }}</div>
            <div class="statement-badge">{{ __('STATEMENT OF FEE ACCOUNT / LEDGER') }}</div>
        </div>

        {{-- Student Details --}}
        <div class="row pt-3 pb-2 border-bottom">
            <div class="col-7">
                <table class="table-sm table-borderless" style="line-height: 1.6;">
                    <tr>
                        <td class="text-muted font-weight-bold" style="width: 120px;">{{ __('Student Name') }}:</td>
                        <td class="font-weight-bold">{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Admission No') }}:</td>
                        <td>{{ $student->student_record->adm_no ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Class & Section') }}:</td>
                        <td>{{ $student->student_record->my_class->name ?? '-' }} {{ $student->student_record->section ? '('.$student->student_record->section->name.')' : '' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-5 text-right">
                <table class="table-sm table-borderless float-right" style="line-height: 1.6;">
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Academic Year') }}:</td>
                        <td class="font-weight-bold">{{ $academic_year }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">{{ __('Statement Date') }}:</td>
                        <td>{{ App\Helpers\NepaliHelper::formatBsDate(now()) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Transactions --}}
        <table class="table table-bordered table-sm table-ledger mt-3">
            <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th style="width: 100px;">{{ __('Date (BS)') }}</th>
                <th style="width: 130px;">{{ __('Reference #') }}</th>
                <th>{{ __('Description') }}</th>
                <th class="text-right" style="width: 110px;">{{ __('Debit (रु)') }}</th>
                <th class="text-right" style="width: 110px;">{{ __('Credit (रु)') }}</th>
                <th class="text-right" style="width: 120px;">{{ __('Balance (रु)') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($entries as $entry)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $entry->entry_date_bs }}</td>
                    <td class="font-weight-bold">{{ $entry->reference_no }}</td>
                    <td>{{ $entry->description }}</td>
                    <td class="text-right">{{ $entry->debit > 0 ? App\Helpers\NepaliHelper::formatNpr($entry->debit) : '-' }}</td>
                    <td class="text-right">{{ $entry->credit > 0 ? App\Helpers\NepaliHelper::formatNpr($entry->credit) : '-' }}</td>
                    <td class="text-right font-weight-semibold">
                        {{ App\Helpers\NepaliHelper::formatNpr(abs($entry->computed_running_balance)) }} {{ $entry->computed_running_balance >= 0 ? 'Dr' : 'Cr' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot class="bg-light font-weight-bold">
            <tr>
                <td colspan="4" class="text-right">{{ __('Totals') }}:</td>
                <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($total_debit) }}</td>
                <td class="text-right text-success">{{ App\Helpers\NepaliHelper::formatNpr($total_credit) }}</td>
                <td class="text-right {{ $net_outstanding > 0 ? 'text-danger' : 'text-success' }}">
                    {{ App\Helpers\NepaliHelper::formatNpr(abs($net_outstanding)) }} {{ $net_outstanding >= 0 ? 'Dr' : 'Cr' }}
                </td>
            </tr>
            </tfoot>
        </table>

        {{-- Summary --}}
        <div class="row pt-3 justify-content-end">
            <div class="col-5">
                <table class="table table-sm table-bordered">
                    <tr>
                        <td>{{ __('Total Billed / Debits') }}:</td>
                        <td class="text-right font-weight-bold">{{ App\Helpers\NepaliHelper::formatNpr($total_debit) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Total Paid / Credits') }}:</td>
                        <td class="text-right font-weight-bold text-success">{{ App\Helpers\NepaliHelper::formatNpr($total_credit) }}</td>
                    </tr>
                    <tr class="h6 font-weight-bold {{ $net_outstanding > 0 ? 'text-danger' : 'text-success' }}">
                        <td>{{ $net_outstanding > 0 ? __('Net Balance Due') : __('Advance Credit') }}:</td>
                        <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr(abs($net_outstanding)) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Signatures --}}
        <div class="row pt-4 mt-3">
            <div class="col-6">
                <div class="sig-line">{{ __('Prepared By (Accountant)') }}</div>
            </div>
            <div class="col-6 text-right">
                <div class="sig-line float-right">{{ __('Verified By / Seal') }}</div>
            </div>
        </div>
    </div>

</body>
</html>
