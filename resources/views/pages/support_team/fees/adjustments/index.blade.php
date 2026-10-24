@extends('layouts.master')
@section('page_title', __('Discounts, Waivers & Refunds Audit'))
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-bold">
                <i class="icon-shield-check mr-2 text-warning"></i> {{ __('Discounts, Fee Waivers & Refunds Audit Log') }} ({{ $academic_year }})
            </h5>
            <div class="header-elements">
                <a href="{{ route('fees.adjustments.create') }}" class="btn btn-warning btn-sm">
                    <i class="icon-plus2 mr-1"></i> {{ __('New Adjustment / Refund') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('fees.adjustments.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-semibold">{{ __('Adjustment Type') }}:</label>
                            <select name="adjustment_type" class="form-control select">
                                <option value="">{{ __('All Adjustment Types') }}</option>
                                <option value="discount" {{ $selected_type === 'discount' ? 'selected' : '' }}>{{ __('Discount') }}</option>
                                <option value="waiver" {{ $selected_type === 'waiver' ? 'selected' : '' }}>{{ __('Fee Waiver') }}</option>
                                <option value="scholarship" {{ $selected_type === 'scholarship' ? 'selected' : '' }}>{{ __('Scholarship') }}</option>
                                <option value="refund" {{ $selected_type === 'refund' ? 'selected' : '' }}>{{ __('Refund') }}</option>
                                <option value="correction" {{ $selected_type === 'correction' ? 'selected' : '' }}>{{ __('Correction') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-auto mb-3">
                        <button type="submit" class="btn btn-secondary btn-block">
                            <i class="icon-filter3 mr-1"></i> {{ __('Filter') }}
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Reference #') }}</th>
                        <th>{{ __('Student') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Date (BS)') }}</th>
                        <th>{{ __('Linked Document') }}</th>
                        <th class="text-right">{{ __('Amount') }}</th>
                        <th>{{ __('Documented Reason') }}</th>
                        <th>{{ __('Authorized By') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($adjustments as $adj)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-weight-bold text-primary">{{ $adj->adjustment_no }}</td>
                            <td>
                                <span class="font-weight-semibold">{{ $adj->student->name ?? 'N/A' }}</span>
                                @if($adj->student && $adj->student->student_record)
                                    <br><small class="text-muted">{{ $adj->student->student_record->adm_no }}</small>
                                @endif
                            </td>
                            <td>
                                @if($adj->adjustment_type === 'discount')
                                    <span class="badge badge-info">{{ __('Discount') }}</span>
                                @elseif($adj->adjustment_type === 'waiver')
                                    <span class="badge badge-warning">{{ __('Waiver') }}</span>
                                @elseif($adj->adjustment_type === 'scholarship')
                                    <span class="badge badge-primary">{{ __('Scholarship') }}</span>
                                @elseif($adj->adjustment_type === 'refund')
                                    <span class="badge badge-danger">{{ __('Refund') }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($adj->adjustment_type) }}</span>
                                @endif
                            </td>
                            <td>{{ $adj->adjustment_date_bs }}</td>
                            <td>
                                @if($adj->invoice)
                                    <a href="{{ route('fees.invoices.show', $adj->invoice->id) }}">
                                        {{ $adj->invoice->invoice_no }}
                                    </a>
                                @elseif($adj->payment)
                                    <a href="{{ route('fees.receipts.show', $adj->payment->id) }}">
                                        {{ $adj->payment->receipt_no }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-right font-weight-bold {{ $adj->adjustment_type === 'refund' ? 'text-danger' : 'text-success' }}">
                                {{ App\Helpers\NepaliHelper::formatNpr($adj->amount) }}
                            </td>
                            <td>{{ $adj->reason }}</td>
                            <td>{{ $adj->authorizer->name ?? 'Admin' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                {{ __('No adjustments or refunds recorded.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $adjustments->links() }}
            </div>
        </div>
    </div>

@endsection
