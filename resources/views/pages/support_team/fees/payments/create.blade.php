@extends('layouts.master')
@section('page_title', __('Record Fee Payment'))
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline bg-light">
            <h5 class="card-title font-weight-bold">
                <i class="icon-cash3 mr-2 text-success"></i> {{ __('Record Fee Payment & Issue Receipt') }} ({{ $academic_year }})
            </h5>
            <div class="header-elements">
                <a href="{{ route('fees.payments.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="icon-arrow-left52 mr-1"></i> {{ __('Back to Payments') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(!$invoice && !$student)
                {{-- Step 1: Select Student --}}
                <div class="alert alert-info">
                    <i class="icon-info22 mr-1"></i> {{ __('Please select a class and student to record payment.') }}
                </div>
                <form method="GET" action="{{ route('fees.payments.create') }}">
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
                {{-- Payment Recording Form --}}
                <form action="{{ route('fees.payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="academic_year" value="{{ $academic_year }}">
                    <input type="hidden" name="student_id" value="{{ $student ? $student->id : $invoice->student_id }}">
                    <input type="hidden" name="idempotency_token" value="{{ 'PAY-' . ($student ? $student->id : $invoice->student_id) . '-' . time() . '-' . mt_rand(1000, 9999) }}">

                    {{-- Student & Invoice Card --}}
                    <div class="p-3 bg-light rounded border mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold mb-1 text-dark">
                                    {{ __('Student') }}: <span class="text-primary">{{ $student ? $student->name : $invoice->student->name }}</span>
                                </h6>
                                <div class="text-muted small">
                                    {{ __('Admission No') }}: {{ ($student && $student->student_record) ? $student->student_record->adm_no : ($invoice->student->student_record->adm_no ?? '-') }} |
                                    {{ __('Class') }}: {{ ($student && $student->student_record && $student->student_record->my_class) ? $student->student_record->my_class->name : ($invoice->my_class->name ?? '-') }}
                                </div>
                            </div>
                            <div class="col-md-6 text-md-right">
                                @if($invoice)
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                    <div class="font-weight-bold text-dark">{{ __('Invoice') }}: {{ $invoice->invoice_no }} ({{ $invoice->fee_period }})</div>
                                    <div class="h5 mb-0 font-weight-bold text-danger">
                                        {{ __('Outstanding Balance') }}: {{ App\Helpers\NepaliHelper::formatNpr($invoice->balance) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(!$invoice && isset($student_invoices) && count($student_invoices))
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">{{ __('Apply Payment to Specific Outstanding Invoice (Recommended)') }}:</label>
                            <select name="invoice_id" id="invoice_selector" class="form-control select" onchange="updatePayAmount(this)">
                                <option value="">{{ __('General Payment / Advance Account Credit') }}</option>
                                @foreach($student_invoices as $sinv)
                                    <option value="{{ $sinv->id }}" data-balance="{{ $sinv->balance }}">
                                        {{ $sinv->invoice_no }} - {{ $sinv->fee_period }} (Due: {{ App\Helpers\NepaliHelper::formatNpr($sinv->balance) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Amount to Collect (NPR)') }}: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text font-weight-bold">रु</span>
                                    </div>
                                    <input type="number" step="0.01" min="0.01" name="amount" id="pay_amount" class="form-control form-control-lg font-weight-bold text-success" required value="{{ $invoice ? $invoice->balance : '' }}" placeholder="0.00">
                                </div>
                                @if($invoice)
                                    <small class="form-text text-muted">
                                        <a href="javascript:void(0)" onclick="document.getElementById('pay_amount').value = '{{ $invoice->balance }}'">
                                            {{ __('Click here to pay full balance (:bal)', ['bal' => App\Helpers\NepaliHelper::formatNpr($invoice->balance)]) }}
                                        </a>
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Payment Method') }}: <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-control select" required>
                                    <option value="cash">{{ __('Cash') }}</option>
                                    <option value="bank_transfer">{{ __('Bank Transfer / Fonepay QR') }}</option>
                                    <option value="esewa">eSewa</option>
                                    <option value="khalti">Khalti</option>
                                    <option value="cheque">{{ __('Cheque') }}</option>
                                    <option value="other">{{ __('Other') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Payment Date (BS/AD)') }}:</label>
                                <div class="input-group">
                                    <input type="text" name="payment_date" class="form-control" value="{{ App\Helpers\NepaliHelper::formatBsDate(now(), 'Y-m-d') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <input type="checkbox" name="is_date_bs" value="1" checked class="mr-1"> BS
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Transaction Reference / Bank Slip # / Cheque #') }}:</label>
                                <input type="text" name="transaction_reference" class="form-control" placeholder="e.g. Bank Voucher # / Fonepay Ref #">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('Payment Remarks / Cashier Notes') }}:</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="{{ __('Optional payment remarks') }}"></textarea>
                    </div>

                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="icon-checkmark mr-1"></i> {{ __('Confirm Payment & Generate Official Receipt') }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function updatePayAmount(select) {
            let option = select.options[select.selectedIndex];
            let bal = option.getAttribute('data-balance');
            if (bal) {
                document.getElementById('pay_amount').value = parseFloat(bal).toFixed(2);
            }
        }
    </script>
@endsection
