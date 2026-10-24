@extends('layouts.master')
@section('page_title', __('Fee Payment Collections & Receipts'))
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-bold">
                <i class="icon-cash mr-2 text-success"></i> {{ __('Fee Payment Collections & Receipts') }} ({{ $academic_year }})
            </h5>
            <div class="header-elements">
                <a href="{{ route('fees.payments.create') }}" class="btn btn-success btn-sm">
                    <i class="icon-plus2 mr-1"></i> {{ __('Record New Payment') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('fees.payments.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-semibold">{{ __('Payment Method') }}:</label>
                            <select name="payment_method" class="form-control select">
                                <option value="">{{ __('All Methods') }}</option>
                                <option value="cash" {{ $selected_method === 'cash' ? 'selected' : '' }}>{{ __('Cash') }}</option>
                                <option value="bank_transfer" {{ $selected_method === 'bank_transfer' ? 'selected' : '' }}>{{ __('Bank Transfer / QR') }}</option>
                                <option value="esewa" {{ $selected_method === 'esewa' ? 'selected' : '' }}>eSewa</option>
                                <option value="khalti" {{ $selected_method === 'khalti' ? 'selected' : '' }}>Khalti</option>
                                <option value="cheque" {{ $selected_method === 'cheque' ? 'selected' : '' }}>{{ __('Cheque') }}</option>
                                <option value="other" {{ $selected_method === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="font-weight-semibold">{{ __('Search (Receipt / Ref / Student)') }}:</label>
                            <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="{{ __('Receipt #, Bank Ref, or Student Name...') }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-auto mb-3">
                        <button type="submit" class="btn btn-secondary btn-block">
                            <i class="icon-filter3 mr-1"></i> {{ __('Filter Collections') }}
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Receipt #') }}</th>
                        <th>{{ __('Student') }}</th>
                        <th>{{ __('Class') }}</th>
                        <th>{{ __('Date (BS)') }}</th>
                        <th>{{ __('Method') }}</th>
                        <th>{{ __('Transaction Ref') }}</th>
                        <th class="text-right">{{ __('Amount Collected') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($payments as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-weight-bold text-primary">
                                <a href="{{ route('fees.receipts.show', $p->id) }}">{{ $p->receipt_no }}</a>
                            </td>
                            <td>
                                <span class="font-weight-semibold">{{ $p->student->name ?? 'N/A' }}</span>
                                @if($p->student && $p->student->student_record)
                                    <br><small class="text-muted">{{ $p->student->student_record->adm_no }}</small>
                                @endif
                            </td>
                            <td>{{ $p->student && $p->student->student_record && $p->student->student_record->my_class ? $p->student->student_record->my_class->name : '-' }}</td>
                            <td>{{ $p->payment_date_bs }}</td>
                            <td>
                                <span class="badge badge-light border font-weight-bold text-uppercase">
                                    {{ $p->payment_method }}
                                </span>
                            </td>
                            <td>{{ $p->transaction_reference ?: '-' }}</td>
                            <td class="text-right font-weight-bold text-success h6 mb-0">
                                {{ App\Helpers\NepaliHelper::formatNpr($p->amount) }}
                            </td>
                            <td>
                                @if($p->status === 'completed')
                                    <span class="badge badge-success">{{ __('Completed') }}</span>
                                @elseif($p->status === 'refunded')
                                    <span class="badge badge-danger">{{ __('Refunded') }}</span>
                                @elseif($p->status === 'partially_refunded')
                                    <span class="badge badge-warning">{{ __('Partial Refund') }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $p->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('fees.receipts.show', $p->id) }}" class="dropdown-item">
                                                <i class="icon-eye"></i> {{ __('View Receipt') }}
                                            </a>
                                            <a href="{{ route('fees.receipts.print', $p->id) }}" target="_blank" class="dropdown-item">
                                                <i class="icon-printer"></i> {{ __('Print Receipt') }}
                                            </a>
                                            @if($p->invoice_id)
                                                <a href="{{ route('fees.invoices.show', $p->invoice_id) }}" class="dropdown-item">
                                                    <i class="icon-file-text"></i> {{ __('View Invoice') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('fees.ledger.show', $p->student_id) }}" class="dropdown-item">
                                                <i class="icon-history"></i> {{ __('Student Ledger') }}
                                            </a>
                                            @if($p->status !== 'refunded' && Qs::userIsTeamSA())
                                                <a href="{{ route('fees.adjustments.create', ['student_id' => $p->student_id, 'payment_id' => $p->id, 'type' => 'refund']) }}" class="dropdown-item text-danger">
                                                    <i class="icon-undo"></i> {{ __('Issue Refund') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                {{ __('No payments recorded matching criteria.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $payments->links() }}
            </div>
        </div>
    </div>

@endsection
