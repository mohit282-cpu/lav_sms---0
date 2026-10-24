@extends('layouts.master')
@section('page_title', __('Student Fee Invoices'))
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-bold">
                <i class="icon-file-text mr-2 text-primary"></i> {{ __('Student Fee Invoices') }} ({{ $academic_year }})
            </h5>
            <div class="header-elements">
                <a href="{{ route('fees.invoices.create') }}" class="btn btn-primary btn-sm">
                    <i class="icon-plus2 mr-1"></i> {{ __('Generate Invoices') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('fees.invoices.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-semibold">{{ __('Class') }}:</label>
                            <select name="my_class_id" class="form-control select">
                                <option value="">{{ __('All Classes') }}</option>
                                @foreach($classes as $c)
                                    <option value="{{ $c->id }}" {{ $selected_class == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-semibold">{{ __('Status') }}:</label>
                            <select name="status" class="form-control select">
                                <option value="">{{ __('All Statuses') }}</option>
                                <option value="unpaid" {{ $selected_status === 'unpaid' ? 'selected' : '' }}>{{ __('Unpaid') }}</option>
                                <option value="partially_paid" {{ $selected_status === 'partially_paid' ? 'selected' : '' }}>{{ __('Partially Paid') }}</option>
                                <option value="paid" {{ $selected_status === 'paid' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-semibold">{{ __('Search (Invoice / Student)') }}:</label>
                            <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="{{ __('Search invoice # or student name...') }}">
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
                        <th>{{ __('Invoice #') }}</th>
                        <th>{{ __('Student') }}</th>
                        <th>{{ __('Class') }}</th>
                        <th>{{ __('Period') }}</th>
                        <th>{{ __('Date (BS)') }}</th>
                        <th>{{ __('Due Date (BS)') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Paid') }}</th>
                        <th>{{ __('Balance') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($invoices as $inv)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-weight-bold text-primary">
                                <a href="{{ route('fees.invoices.show', $inv->id) }}">{{ $inv->invoice_no }}</a>
                            </td>
                            <td>
                                <span class="font-weight-semibold">{{ $inv->student->name ?? 'N/A' }}</span>
                                @if($inv->student && $inv->student->student_record)
                                    <br><small class="text-muted">{{ $inv->student->student_record->adm_no }}</small>
                                @endif
                            </td>
                            <td>{{ $inv->my_class->name ?? '-' }} {{ $inv->section ? '('.$inv->section->name.')' : '' }}</td>
                            <td><span class="badge badge-light border">{{ $inv->fee_period ?? '-' }}</span></td>
                            <td>{{ $inv->invoice_date_bs }}</td>
                            <td>{{ $inv->due_date_bs }}</td>
                            <td class="font-weight-bold">{{ App\Helpers\NepaliHelper::formatNpr($inv->net_total) }}</td>
                            <td class="text-success">{{ App\Helpers\NepaliHelper::formatNpr($inv->paid_amount) }}</td>
                            <td class="font-weight-bold {{ $inv->balance > 0 ? 'text-danger' : 'text-muted' }}">
                                {{ App\Helpers\NepaliHelper::formatNpr($inv->balance) }}
                            </td>
                            <td>
                                @if($inv->status === 'paid')
                                    <span class="badge badge-success">{{ __('Paid') }}</span>
                                @elseif($inv->status === 'partially_paid')
                                    <span class="badge badge-warning">{{ __('Partial') }}</span>
                                @elseif($inv->status === 'cancelled')
                                    <span class="badge badge-danger">{{ __('Cancelled') }}</span>
                                @else
                                    <span class="badge badge-danger">{{ __('Unpaid') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('fees.invoices.show', $inv->id) }}" class="dropdown-item">
                                                <i class="icon-eye"></i> {{ __('View Invoice') }}
                                            </a>
                                            <a href="{{ route('fees.invoices.print', $inv->id) }}" target="_blank" class="dropdown-item">
                                                <i class="icon-printer"></i> {{ __('Print Invoice') }}
                                            </a>
                                            @if($inv->balance > 0)
                                                <a href="{{ route('fees.payments.create', ['invoice_id' => $inv->id]) }}" class="dropdown-item text-success font-weight-bold">
                                                    <i class="icon-cash"></i> {{ __('Record Payment') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('fees.ledger.show', $inv->student_id) }}" class="dropdown-item">
                                                <i class="icon-history"></i> {{ __('Student Ledger') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted py-4">
                                {{ __('No invoices found matching criteria.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>

@endsection
