@extends('layouts.master')
@section('page_title', __('Student Fee Ledger') . ' - ' . $student->name)
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-bold">
                <i class="icon-history mr-2 text-primary"></i> {{ __('Student Fee Ledger') }}: <span class="text-primary">{{ $student->name }}</span>
            </h5>
            <div class="header-elements">
                <a href="{{ route('fees.ledger.print', $student->id) }}" target="_blank" class="btn btn-outline-primary btn-sm mr-2">
                    <i class="icon-printer mr-1"></i> {{ __('Print Statement') }}
                </a>
                @if(Qs::userIsTeamAccount())
                    <a href="{{ route('fees.payments.create', ['student_id' => $student->id]) }}" class="btn btn-success btn-sm mr-2">
                        <i class="icon-cash mr-1"></i> {{ __('Record Payment') }}
                    </a>
                    <a href="{{ route('fees.adjustments.create', ['student_id' => $student->id]) }}" class="btn btn-outline-warning btn-sm">
                        <i class="icon-shield-check mr-1"></i> {{ __('Apply Adjustment / Waiver') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            {{-- Student Summary Card --}}
            <div class="p-3 bg-light rounded border mb-4">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="{{ $student->photo }}" class="rounded-circle img-fluid border" style="max-height: 80px;" alt="photo">
                    </div>
                    <div class="col-md-5">
                        <h5 class="font-weight-bold mb-1 text-dark">{{ $student->name }}</h5>
                        <div class="text-muted small">
                            <strong>{{ __('Admission No') }}:</strong> {{ $student->student_record->adm_no ?? '-' }} |
                            <strong>{{ __('Class') }}:</strong> {{ $student->student_record->my_class->name ?? '-' }} {{ $student->student_record->section ? '('.$student->student_record->section->name.')' : '' }}
                        </div>
                        <div class="text-muted small">
                            <strong>{{ __('Academic Year') }}:</strong> <span class="badge badge-info">{{ $academic_year }}</span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <form method="GET" action="{{ route('fees.ledger.show', $student->id) }}" class="form-inline justify-content-md-end">
                            <label class="mr-2 font-weight-semibold">{{ __('Session') }}:</label>
                            <input type="text" name="academic_year" class="form-control form-control-sm mr-2" value="{{ $academic_year }}" placeholder="e.g. 2083/84 BS" style="width: 140px;">
                            <button type="submit" class="btn btn-sm btn-secondary">{{ __('Filter') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- 3 Key Balance Metric Cards --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card card-body bg-light border text-center p-3">
                        <div class="text-muted text-uppercase font-weight-bold small">{{ __('Total Charges / Debits') }}</div>
                        <div class="h4 font-weight-bold text-dark mt-2 mb-0">
                            {{ App\Helpers\NepaliHelper::formatNpr($total_debit) }}
                        </div>
                        <small class="text-muted mt-1">{{ __('Total invoices issued') }}</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-body bg-light border text-center p-3">
                        <div class="text-muted text-uppercase font-weight-bold small">{{ __('Total Credits & Payments') }}</div>
                        <div class="h4 font-weight-bold text-success mt-2 mb-0">
                            {{ App\Helpers\NepaliHelper::formatNpr($total_credit) }}
                        </div>
                        <small class="text-muted mt-1">{{ __('Payments + approved waivers') }}</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-body {{ $net_outstanding > 0 ? 'bg-danger-light border-danger' : 'bg-success-light border-success' }} text-center p-3">
                        <div class="text-uppercase font-weight-bold small {{ $net_outstanding > 0 ? 'text-danger' : 'text-success' }}">
                            {{ $net_outstanding > 0 ? __('Outstanding Dues Payable') : __('Account Credit / Advance') }}
                        </div>
                        <div class="h4 font-weight-bold {{ $net_outstanding > 0 ? 'text-danger' : 'text-success' }} mt-2 mb-0">
                            {{ App\Helpers\NepaliHelper::formatNpr(abs($net_outstanding)) }}
                        </div>
                        <small class="mt-1 font-weight-semibold {{ $net_outstanding > 0 ? 'text-danger' : 'text-success' }}">
                            {{ $net_outstanding > 0 ? __('Payment is pending') : __('No outstanding balance') }}
                        </small>
                    </div>
                </div>
            </div>

            {{-- Chronological Ledger Table --}}
            <h6 class="font-weight-bold mb-2">
                <i class="icon-list-ordered mr-1 text-primary"></i> {{ __('Chronological Transaction Ledger') }}
            </h6>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="bg-light">
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>{{ __('Date (BS)') }}</th>
                        <th>{{ __('Reference #') }}</th>
                        <th>{{ __('Transaction Type') }}</th>
                        <th>{{ __('Description / Particulars') }}</th>
                        <th class="text-right" style="width: 140px;">{{ __('Debit (Charges)') }}</th>
                        <th class="text-right" style="width: 140px;">{{ __('Credit (Payments)') }}</th>
                        <th class="text-right" style="width: 150px;">{{ __('Balance (रु)') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($entries as $entry)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="font-weight-semibold">{{ $entry->entry_date_bs }}</span>
                                <br><small class="text-muted">{{ $entry->entry_date->format('Y-m-d') }}</small>
                            </td>
                            <td class="font-weight-bold">
                                @if($entry->entry_type === 'invoice' && $entry->source_id)
                                    <a href="{{ route('fees.invoices.show', $entry->source_id) }}">{{ $entry->reference_no }}</a>
                                @elseif($entry->entry_type === 'payment' && $entry->source_id)
                                    <a href="{{ route('fees.receipts.show', $entry->source_id) }}" class="text-success">{{ $entry->reference_no }}</a>
                                @else
                                    {{ $entry->reference_no }}
                                @endif
                            </td>
                            <td>
                                @if($entry->entry_type === 'invoice')
                                    <span class="badge badge-primary">{{ __('Invoice') }}</span>
                                @elseif($entry->entry_type === 'payment')
                                    <span class="badge badge-success">{{ __('Payment') }}</span>
                                @elseif($entry->entry_type === 'discount_waiver')
                                    <span class="badge badge-warning">{{ __('Waiver/Discount') }}</span>
                                @elseif($entry->entry_type === 'refund')
                                    <span class="badge badge-danger">{{ __('Refund') }}</span>
                                @else
                                    <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $entry->entry_type)) }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $entry->description }}
                                @if($entry->authorizer)
                                    <br><small class="text-muted">By: {{ $entry->authorizer->name }}</small>
                                @endif
                            </td>
                            <td class="text-right font-weight-semibold text-danger">
                                {{ $entry->debit > 0 ? App\Helpers\NepaliHelper::formatNpr($entry->debit) : '-' }}
                            </td>
                            <td class="text-right font-weight-semibold text-success">
                                {{ $entry->credit > 0 ? App\Helpers\NepaliHelper::formatNpr($entry->credit) : '-' }}
                            </td>
                            <td class="text-right font-weight-bold {{ $entry->computed_running_balance > 0 ? 'text-danger' : 'text-success' }}">
                                {{ App\Helpers\NepaliHelper::formatNpr(abs($entry->computed_running_balance)) }}
                                <small>({{ $entry->computed_running_balance >= 0 ? 'Dr' : 'Cr' }})</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                {{ __('No transactions recorded in ledger for this student.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot class="bg-light font-weight-bold">
                    <tr>
                        <td colspan="5" class="text-right">{{ __('Totals') }}:</td>
                        <td class="text-right text-danger">{{ App\Helpers\NepaliHelper::formatNpr($total_debit) }}</td>
                        <td class="text-right text-success">{{ App\Helpers\NepaliHelper::formatNpr($total_credit) }}</td>
                        <td class="text-right {{ $net_outstanding > 0 ? 'text-danger' : 'text-success' }}">
                            {{ App\Helpers\NepaliHelper::formatNpr(abs($net_outstanding)) }} {{ $net_outstanding >= 0 ? 'Dr' : 'Cr' }}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection
