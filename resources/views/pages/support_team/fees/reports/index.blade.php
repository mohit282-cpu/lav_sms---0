@extends('layouts.master')
@section('page_title', __('Fee Collection & Financial Reports'))
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-bold">
                <i class="icon-pie5 mr-2 text-primary"></i> {{ __('Nepal School Fee & Financial Reports') }} ({{ $academic_year }})
            </h5>
            <div class="header-elements">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.print()">
                    <i class="icon-printer mr-1"></i> {{ __('Print Report') }}
                </button>
            </div>
        </div>

        <div class="card-body">
            {{-- Filter Bar --}}
            <form method="GET" action="{{ route('fees.reports.index') }}" class="mb-4 no-print">
                <div class="row bg-light p-3 rounded border">
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label class="font-weight-semibold">{{ __('Academic Year (BS)') }}:</label>
                            <input type="text" name="academic_year" class="form-control form-control-sm" value="{{ $academic_year }}" placeholder="e.g. 2083/84 BS">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label class="font-weight-semibold">{{ __('From Date (BS)') }}:</label>
                            <input type="text" name="date_from" class="form-control form-control-sm" value="{{ $filters['date_from'] ?? '' }}" placeholder="YYYY-MM-DD">
                            <input type="hidden" name="is_bs" value="1">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label class="font-weight-semibold">{{ __('To Date (BS)') }}:</label>
                            <input type="text" name="date_to" class="form-control form-control-sm" value="{{ $filters['date_to'] ?? '' }}" placeholder="YYYY-MM-DD">
                        </div>
                    </div>
                    <div class="col-md-3 mt-auto">
                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                            <i class="icon-filter3 mr-1"></i> {{ __('Apply Filters') }}
                        </button>
                    </div>
                </div>
            </form>

            {{-- Top KPI Cards --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card card-body bg-light border text-center p-3 mb-2">
                        <div class="text-muted text-uppercase font-weight-bold small">{{ __('Total Collected Revenue') }}</div>
                        <div class="h3 font-weight-bold text-success mt-2 mb-0">
                            {{ App\Helpers\NepaliHelper::formatNpr($total_revenue_collected) }}
                        </div>
                        <small class="text-muted">{{ __('Actual payments received') }}</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body bg-light border text-center p-3 mb-2">
                        <div class="text-muted text-uppercase font-weight-bold small">{{ __('Cash Collections') }}</div>
                        <div class="h4 font-weight-bold text-dark mt-2 mb-0">
                            {{ App\Helpers\NepaliHelper::formatNpr($payment_methods['cash']) }}
                        </div>
                        <small class="text-muted">{{ __('Direct cash counter') }}</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body bg-light border text-center p-3 mb-2">
                        <div class="text-muted text-uppercase font-weight-bold small">{{ __('Bank & QR Transfers') }}</div>
                        <div class="h4 font-weight-bold text-primary mt-2 mb-0">
                            {{ App\Helpers\NepaliHelper::formatNpr($payment_methods['bank_transfer']) }}
                        </div>
                        <small class="text-muted">{{ __('Direct bank deposit / Fonepay') }}</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body bg-light border text-center p-3 mb-2">
                        <div class="text-muted text-uppercase font-weight-bold small">{{ __('Digital Wallets (eSewa/Khalti)') }}</div>
                        <div class="h4 font-weight-bold text-info mt-2 mb-0">
                            {{ App\Helpers\NepaliHelper::formatNpr($payment_methods['esewa'] + $payment_methods['khalti']) }}
                        </div>
                        <small class="text-muted">{{ __('Digital payment gateways') }}</small>
                    </div>
                </div>
            </div>

            {{-- Tab Navigation --}}
            <ul class="nav nav-tabs nav-tabs-highlight mb-3 no-print" role="tablist">
                <li class="nav-item">
                    <a href="#tab-daily" class="nav-link {{ $active_tab === 'daily' ? 'active' : '' }}" data-toggle="tab">
                        <i class="icon-calendar mr-1"></i> {{ __('Daily Collections') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#tab-class" class="nav-link {{ $active_tab === 'class' ? 'active' : '' }}" data-toggle="tab">
                        <i class="icon-stats-growth mr-1"></i> {{ __('Class-Wise Collections') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#tab-outstanding" class="nav-link {{ $active_tab === 'outstanding' ? 'active' : '' }}" data-toggle="tab">
                        <i class="icon-alarm mr-1"></i> {{ __('Outstanding Invoices') }}
                        @if(count($outstanding_invoices))
                            <span class="badge badge-danger ml-1">{{ count($outstanding_invoices) }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#tab-discounts" class="nav-link {{ $active_tab === 'discounts' ? 'active' : '' }}" data-toggle="tab">
                        <i class="icon-shield-check mr-1"></i> {{ __('Discounts & Waivers Audit') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                {{-- TAB 1: Daily Collections --}}
                <div class="tab-pane fade {{ $active_tab === 'daily' ? 'show active' : '' }}" id="tab-daily">
                    <h6 class="font-weight-bold mb-2">{{ __('Daily Fee Collection Breakdown') }}</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('Date (BS)') }}</th>
                                <th>{{ __('Date (AD)') }}</th>
                                <th class="text-center">{{ __('Receipts Count') }}</th>
                                <th class="text-right">{{ __('Cash (रु)') }}</th>
                                <th class="text-right">{{ __('Bank / QR (रु)') }}</th>
                                <th class="text-right">{{ __('Digital Wallets (रु)') }}</th>
                                <th class="text-right">{{ __('Other (रु)') }}</th>
                                <th class="text-right">{{ __('Total Collected (रु)') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($daily_collection as $dc)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold">{{ $dc['date_bs'] }}</td>
                                    <td class="text-muted">{{ $dc['date_ad'] }}</td>
                                    <td class="text-center"><span class="badge badge-light border">{{ $dc['count'] }}</span></td>
                                    <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($dc['cash']) }}</td>
                                    <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($dc['bank']) }}</td>
                                    <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($dc['digital']) }}</td>
                                    <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($dc['cheque'] + $dc['other']) }}</td>
                                    <td class="text-right font-weight-bold text-success">{{ App\Helpers\NepaliHelper::formatNpr($dc['total']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-3">{{ __('No collections recorded for the selected period.') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 2: Class-Wise Collections --}}
                <div class="tab-pane fade {{ $active_tab === 'class' ? 'show active' : '' }}" id="tab-class">
                    <h6 class="font-weight-bold mb-2">{{ __('Class-Wise Billing, Collection & Recovery Rates') }}</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('Class Name') }}</th>
                                <th class="text-center">{{ __('Invoices') }}</th>
                                <th class="text-right">{{ __('Total Billed (रु)') }}</th>
                                <th class="text-right">{{ __('Total Collected (रु)') }}</th>
                                <th class="text-right">{{ __('Outstanding Balance (रु)') }}</th>
                                <th class="text-center">{{ __('Recovery Rate') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($class_collection as $cc)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold">{{ $cc['class_name'] }}</td>
                                    <td class="text-center">{{ $cc['invoice_count'] }}</td>
                                    <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($cc['total_billed']) }}</td>
                                    <td class="text-right font-weight-semibold text-success">{{ App\Helpers\NepaliHelper::formatNpr($cc['total_paid']) }}</td>
                                    <td class="text-right font-weight-semibold {{ $cc['total_outstanding'] > 0 ? 'text-danger' : 'text-muted' }}">
                                        {{ App\Helpers\NepaliHelper::formatNpr($cc['total_outstanding']) }}
                                    </td>
                                    <td class="text-center">
                                        <div class="progress" style="height: 18px;">
                                            <div class="progress-bar {{ $cc['collection_percentage'] >= 75 ? 'bg-success' : ($cc['collection_percentage'] >= 40 ? 'bg-warning' : 'bg-danger') }}" style="width: {{ $cc['collection_percentage'] }}%;">
                                                {{ $cc['collection_percentage'] }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 3: Outstanding Invoices --}}
                <div class="tab-pane fade {{ $active_tab === 'outstanding' ? 'show active' : '' }}" id="tab-outstanding">
                    <h6 class="font-weight-bold mb-2 text-danger">{{ __('Outstanding & Overdue Invoices') }}</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('Invoice #') }}</th>
                                <th>{{ __('Student Name') }}</th>
                                <th>{{ __('Class') }}</th>
                                <th>{{ __('Period') }}</th>
                                <th>{{ __('Due Date (BS)') }}</th>
                                <th class="text-right">{{ __('Billed Total') }}</th>
                                <th class="text-right">{{ __('Paid') }}</th>
                                <th class="text-right">{{ __('Balance Due') }}</th>
                                <th class="text-center no-print">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($outstanding_invoices as $oi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold text-primary">{{ $oi->invoice_no }}</td>
                                    <td class="font-weight-semibold">{{ $oi->student->name ?? 'N/A' }}</td>
                                    <td>{{ $oi->my_class->name ?? '-' }}</td>
                                    <td>{{ $oi->fee_period ?? '-' }}</td>
                                    <td class="text-danger font-weight-semibold">{{ $oi->due_date_bs }}</td>
                                    <td class="text-right">{{ App\Helpers\NepaliHelper::formatNpr($oi->net_total) }}</td>
                                    <td class="text-right text-success">{{ App\Helpers\NepaliHelper::formatNpr($oi->paid_amount) }}</td>
                                    <td class="text-right font-weight-bold text-danger">{{ App\Helpers\NepaliHelper::formatNpr($oi->balance) }}</td>
                                    <td class="text-center no-print">
                                        <a href="{{ route('fees.payments.create', ['invoice_id' => $oi->id]) }}" class="btn btn-sm btn-success py-0">
                                            {{ __('Pay') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-3">{{ __('No outstanding invoices found.') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 4: Discounts, Waivers & Refunds Audit --}}
                <div class="tab-pane fade {{ $active_tab === 'discounts' ? 'show active' : '' }}" id="tab-discounts">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-light text-center">
                                <span class="text-muted small text-uppercase font-weight-bold">{{ __('Fee Discounts') }}</span>
                                <div class="h5 font-weight-bold text-info mb-0">{{ App\Helpers\NepaliHelper::formatNpr($discounts_summary['total_discounts']) }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-light text-center">
                                <span class="text-muted small text-uppercase font-weight-bold">{{ __('Approved Waivers') }}</span>
                                <div class="h5 font-weight-bold text-warning mb-0">{{ App\Helpers\NepaliHelper::formatNpr($discounts_summary['total_waivers']) }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-light text-center">
                                <span class="text-muted small text-uppercase font-weight-bold">{{ __('Scholarships') }}</span>
                                <div class="h5 font-weight-bold text-primary mb-0">{{ App\Helpers\NepaliHelper::formatNpr($discounts_summary['total_scholarships']) }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-light text-center">
                                <span class="text-muted small text-uppercase font-weight-bold">{{ __('Total Refunds') }}</span>
                                <div class="h5 font-weight-bold text-danger mb-0">{{ App\Helpers\NepaliHelper::formatNpr($discounts_summary['total_refunds']) }}</div>
                            </div>
                        </div>
                    </div>

                    <h6 class="font-weight-bold mb-2">{{ __('Adjustments & Refunds Detailed Log') }}</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('Ref #') }}</th>
                                <th>{{ __('Student') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Date (BS)') }}</th>
                                <th class="text-right">{{ __('Amount') }}</th>
                                <th>{{ __('Reason') }}</th>
                                <th>{{ __('Authorized By') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($discounts_summary['records'] as $rec)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold">{{ $rec->adjustment_no }}</td>
                                    <td>{{ $rec->student->name ?? 'N/A' }}</td>
                                    <td><span class="badge badge-light border text-uppercase">{{ $rec->adjustment_type }}</span></td>
                                    <td>{{ $rec->adjustment_date_bs }}</td>
                                    <td class="text-right font-weight-bold {{ $rec->adjustment_type === 'refund' ? 'text-danger' : 'text-success' }}">
                                        {{ App\Helpers\NepaliHelper::formatNpr($rec->amount) }}
                                    </td>
                                    <td>{{ $rec->reason }}</td>
                                    <td>{{ $rec->authorizer->name ?? 'Admin' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">{{ __('No adjustments or refunds recorded in this period.') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
