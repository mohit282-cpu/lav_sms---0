@extends('layouts.master')
@section('page_title', __('Create Fee Adjustment / Refund'))
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline bg-light">
            <h5 class="card-title font-weight-bold">
                <i class="icon-shield-check mr-2 text-warning"></i> {{ __('Authorize Fee Adjustment, Waiver or Refund') }}
            </h5>
            <div class="header-elements">
                <a href="{{ route('fees.adjustments.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="icon-arrow-left52 mr-1"></i> {{ __('Back to Adjustments') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(!$student)
                {{-- Select Student --}}
                <div class="alert alert-info">
                    <i class="icon-info22 mr-1"></i> {{ __('Please select a class and student to apply an adjustment or refund.') }}
                </div>
                <form method="GET" action="{{ route('fees.adjustments.create') }}">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Select Class') }}:</label>
                                <select name="my_class_id" class="form-control select" onchange="this.form.submit()">
                                    <option value="">{{ __('Select Class') }}</option>
                                    @foreach($classes as $c)
                                        <option value="{{ $c->id }}" {{ request('my_class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if(request('my_class_id'))
                            @php
                                $classStudents = App\Models\StudentRecord::where('my_class_id', request('my_class_id'))
                                    ->where('session', $academic_year)
                                    ->with('user')
                                    ->get()
                                    ->sortBy('user.name');
                            @endphp
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="font-weight-bold">{{ __('Select Student') }}:</label>
                                    <select name="student_id" class="form-control select-search" onchange="this.form.submit()">
                                        <option value="">{{ __('Select Student') }}</option>
                                        @foreach($classStudents as $cs)
                                            <option value="{{ $cs->user_id }}">{{ $cs->user->name }} ({{ $cs->adm_no }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            @else
                <form action="{{ route('fees.adjustments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="academic_year" value="{{ $academic_year }}">
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <input type="hidden" name="idempotency_token" value="{{ 'ADJ-' . $student->id . '-' . time() . '-' . mt_rand(1000, 9999) }}">

                    {{-- Student Summary Box --}}
                    <div class="p-3 bg-light rounded border mb-4">
                        <h6 class="font-weight-bold mb-1 text-dark">
                            {{ __('Student') }}: <span class="text-primary">{{ $student->name }}</span>
                        </h6>
                        <div class="text-muted small">
                            {{ __('Admission No') }}: {{ $student->student_record->adm_no ?? '-' }} |
                            {{ __('Class') }}: {{ $student->student_record->my_class->name ?? '-' }} |
                            {{ __('Session') }}: {{ $academic_year }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Adjustment Type') }}: <span class="text-danger">*</span></label>
                                <select name="adjustment_type" id="adjustment_type" class="form-control select" onchange="toggleType(this.value)" required>
                                    <option value="discount" {{ request('type') === 'discount' ? 'selected' : '' }}>{{ __('Discount') }}</option>
                                    <option value="waiver" {{ request('type') === 'waiver' ? 'selected' : '' }}>{{ __('Fee Waiver') }}</option>
                                    <option value="scholarship" {{ request('type') === 'scholarship' ? 'selected' : '' }}>{{ __('Scholarship Adjustment') }}</option>
                                    <option value="refund" {{ request('type') === 'refund' ? 'selected' : '' }}>{{ __('Refund to Student') }}</option>
                                    <option value="correction" {{ request('type') === 'correction' ? 'selected' : '' }}>{{ __('Correction Entry') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Amount (NPR)') }}: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text font-weight-bold">रु</span>
                                    </div>
                                    <input type="number" step="0.01" min="0.01" name="amount" id="adj_amount" class="form-control font-weight-bold" required placeholder="0.00">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- If refund, require payment --}}
                    <div class="form-group" id="payment_selector_wrapper" style="display: {{ request('type') === 'refund' ? 'block' : 'none' }};">
                        <label class="font-weight-bold text-danger">{{ __('Select Recorded Payment to Refund Against') }}: <span class="text-danger">*</span></label>
                        <select name="fee_payment_id" id="fee_payment_id" class="form-control select">
                            <option value="">{{ __('Select Payment') }}</option>
                            @if(isset($payments))
                                @foreach($payments as $pm)
                                    <option value="{{ $pm->id }}" {{ request('payment_id') == $pm->id ? 'selected' : '' }} data-amount="{{ $pm->amount }}">
                                        {{ $pm->receipt_no }} - {{ $pm->payment_date_bs }} (Paid: {{ App\Helpers\NepaliHelper::formatNpr($pm->amount) }} via {{ strtoupper($pm->payment_method) }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="form-text text-muted">{{ __('Refunds are strictly traced back to an actual recorded receipt and cannot exceed the paid amount.') }}</small>
                    </div>

                    {{-- If waiver/discount, optional invoice --}}
                    <div class="form-group" id="invoice_selector_wrapper" style="display: {{ request('type') === 'refund' ? 'none' : 'block' }};">
                        <label class="font-weight-bold">{{ __('Apply to Specific Outstanding Invoice (Optional)') }}:</label>
                        <select name="invoice_id" id="invoice_id" class="form-control select">
                            <option value="">{{ __('None / General Account Credit') }}</option>
                            @if(isset($invoices))
                                @foreach($invoices as $inv)
                                    <option value="{{ $inv->id }}" {{ request('invoice_id') == $inv->id ? 'selected' : '' }}>
                                        {{ $inv->invoice_no }} - {{ $inv->fee_period }} (Due: {{ App\Helpers\NepaliHelper::formatNpr($inv->balance) }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Date (BS/AD)') }}:</label>
                                <div class="input-group">
                                    <input type="text" name="adjustment_date" class="form-control" value="{{ App\Helpers\NepaliHelper::formatBsDate(now(), 'Y-m-d') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <input type="checkbox" name="is_date_bs" value="1" checked class="mr-1"> BS
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('Documented Justification / Reason') }}: <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="3" required placeholder="{{ __('Detailed administrative or financial justification for this waiver, discount, or refund (Mandatory for audit trail)') }}"></textarea>
                    </div>

                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-warning btn-lg font-weight-bold">
                            <i class="icon-checkmark-circle mr-1"></i> {{ __('Authorize and Apply Adjustment') }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function toggleType(type) {
            let payWrap = document.getElementById('payment_selector_wrapper');
            let invWrap = document.getElementById('invoice_selector_wrapper');
            let paySelect = document.getElementById('fee_payment_id');

            if (type === 'refund') {
                payWrap.style.display = 'block';
                invWrap.style.display = 'none';
                paySelect.setAttribute('required', 'required');
            } else {
                payWrap.style.display = 'none';
                invWrap.style.display = 'block';
                paySelect.removeAttribute('required');
            }
        }
    </script>
@endsection
