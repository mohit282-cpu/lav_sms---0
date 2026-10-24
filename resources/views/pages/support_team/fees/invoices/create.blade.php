@extends('layouts.master')
@section('page_title', __('Generate Fee Invoice'))
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline bg-light">
            <h5 class="card-title font-weight-bold">
                <i class="icon-file-plus mr-2 text-primary"></i> {{ __('Generate Fee Invoice') }} ({{ $academic_year }})
            </h5>
            <div class="header-elements">
                <a href="{{ route('fees.invoices.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="icon-arrow-left52 mr-1"></i> {{ __('Back to Invoices') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            {{-- Class Selector Form --}}
            <form method="GET" action="{{ route('fees.invoices.create') }}" class="mb-4">
                <div class="row bg-light p-3 rounded border">
                    <div class="col-md-5">
                        <label class="font-weight-bold">{{ __('Select Target Class') }}: <span class="text-danger">*</span></label>
                        <select name="my_class_id" class="form-control select" onchange="this.form.submit()" required>
                            <option value="">{{ __('Choose Class to Load Students & Fees') }}</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ $selected_class_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-7 d-flex align-items-center">
                        <small class="text-muted mt-3">
                            <i class="icon-info22 mr-1 text-info"></i> {{ __('Selecting a class loads all enrolled students and class-specific fee structures.') }}
                        </small>
                    </div>
                </div>
            </form>

            @if($selected_class_id)
                <form action="{{ route('fees.invoices.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="my_class_id" value="{{ $selected_class_id }}">
                    <input type="hidden" name="academic_year" value="{{ $academic_year }}">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Billing Mode') }}: <span class="text-danger">*</span></label>
                                <select name="invoice_mode" id="invoice_mode" class="form-control select" onchange="toggleBillingMode(this.value)" required>
                                    <option value="single">{{ __('Single Student Invoice') }}</option>
                                    <option value="bulk">{{ __('Bulk Invoices (Entire Class :count Students)', ['count' => count($students)]) }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4" id="student_select_wrapper">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Select Student') }}: <span class="text-danger">*</span></label>
                                <select name="student_id" id="student_id" class="form-control select-search" required>
                                    <option value="">{{ __('Select Student') }}</option>
                                    @foreach($students as $sr)
                                        <option value="{{ $sr->user_id }}">{{ $sr->user->name }} ({{ $sr->adm_no }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Fee Period / Description') }}: <span class="text-danger">*</span></label>
                                <input type="text" name="fee_period" class="form-control" required placeholder="e.g. 2083 Baishakh / First Term Exam">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('Invoice Date (BS/AD)') }}:</label>
                                <div class="input-group">
                                    <input type="text" name="invoice_date" class="form-control" value="{{ App\Helpers\NepaliHelper::formatBsDate(now(), 'Y-m-d') }}" placeholder="YYYY-MM-DD">
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
                                <label class="font-weight-bold">{{ __('Due Date (BS/AD)') }}:</label>
                                <div class="input-group">
                                    <input type="text" name="due_date" class="form-control" value="{{ App\Helpers\NepaliHelper::formatBsDate(now()->addDays(15), 'Y-m-d') }}" placeholder="YYYY-MM-DD">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <input type="checkbox" name="is_due_date_bs" value="1" checked class="mr-1"> BS
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pre-configured Fee Templates Quick Fill --}}
                    @if(count($structures))
                        <div class="alert alert-info py-2 mb-3">
                            <span class="font-weight-bold"><i class="icon-magic-wand mr-1"></i> {{ __('Quick-Add Fee Template') }}:</span>
                            @foreach($structures as $st)
                                <button type="button" class="btn btn-sm btn-light border ml-1 mb-1" onclick="addTemplateItem('{{ addslashes($st->title) }}', {{ $st->amount }}, {{ $st->fee_category_id }}, {{ $st->id }}, {{ $st->is_taxable ? 1 : 0 }}, {{ $st->tax_rate }})">
                                    + {{ $st->title }} ({{ App\Helpers\NepaliHelper::formatNpr($st->amount) }})
                                </button>
                            @endforeach
                        </div>
                    @endif

                    {{-- Invoice Items Table --}}
                    <div class="table-responsive mb-3 border rounded">
                        <table class="table table-bordered mb-0" id="invoice_items_table">
                            <thead class="bg-light">
                            <tr>
                                <th>{{ __('Fee Item / Category') }} <span class="text-danger">*</span></th>
                                <th style="width: 160px;">{{ __('Unit Price (रु)') }} <span class="text-danger">*</span></th>
                                <th style="width: 100px;">{{ __('Qty') }}</th>
                                <th style="width: 140px;">{{ __('Discount (रु)') }}</th>
                                <th style="width: 140px;">{{ __('Tax/VAT') }}</th>
                                <th style="width: 150px;">{{ __('Net Total (रु)') }}</th>
                                <th style="width: 50px;"></th>
                            </tr>
                            </thead>
                            <tbody id="items_body">
                            <tr class="item-row">
                                <td>
                                    <input type="text" name="items[0][title]" class="form-control item-title" required placeholder="Fee Description">
                                    <input type="hidden" name="items[0][fee_category_id]" class="item-cat-id" value="">
                                    <input type="hidden" name="items[0][fee_structure_id]" class="item-struct-id" value="">
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="items[0][unit_price]" class="form-control item-price" required value="0.00" oninput="calculateRow(this)">
                                </td>
                                <td>
                                    <input type="number" step="1" min="1" name="items[0][quantity]" class="form-control item-qty" value="1" oninput="calculateRow(this)">
                                </td>
                                <td>
                                    <input type="number" step="0.01" min="0" name="items[0][discount_amount]" class="form-control item-disc" value="0.00" oninput="calculateRow(this)">
                                </td>
                                <td>
                                    <div class="form-check">
                                        <label class="form-check-label small">
                                            <input type="checkbox" name="items[0][is_taxable]" value="1" class="form-check-input item-tax-check" onchange="calculateRow(this)"> {{ __('Taxable') }}
                                        </label>
                                    </div>
                                    <input type="number" step="0.01" name="items[0][tax_rate]" class="form-control form-control-sm item-tax-rate mt-1" value="0.00" placeholder="%" oninput="calculateRow(this)">
                                </td>
                                <td>
                                    <input type="text" readonly class="form-control item-net font-weight-bold text-success" value="0.00">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                                        <i class="icon-cross2"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot class="bg-light font-weight-bold">
                            <tr>
                                <td colspan="5" class="text-right">{{ __('Grand Total') }}:</td>
                                <td>
                                    <span id="grand_total_display" class="font-weight-bold text-success h6">रु 0.00</span>
                                </td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewRow()">
                            <i class="icon-plus2 mr-1"></i> {{ __('Add Another Fee Item') }}
                        </button>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('Invoice Notes / Terms') }}:</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="{{ __('Optional payment instructions or notes for the student/parent') }}"></textarea>
                    </div>

                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="icon-paperplane mr-2"></i> {{ __('Generate and Issue Invoice') }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let rowIndex = 1;

        function toggleBillingMode(mode) {
            let wrapper = document.getElementById('student_select_wrapper');
            let studentSelect = document.getElementById('student_id');
            if (mode === 'bulk') {
                wrapper.style.display = 'none';
                studentSelect.removeAttribute('required');
            } else {
                wrapper.style.display = 'block';
                studentSelect.setAttribute('required', 'required');
            }
        }

        function calculateRow(element) {
            let row = element.closest('.item-row');
            let price = parseFloat(row.querySelector('.item-price').value) || 0;
            let qty = parseFloat(row.querySelector('.item-qty').value) || 1;
            let disc = parseFloat(row.querySelector('.item-disc').value) || 0;
            let isTax = row.querySelector('.item-tax-check').checked;
            let taxRate = parseFloat(row.querySelector('.item-tax-rate').value) || 0;

            let gross = price * qty;
            if (disc > gross) disc = gross;
            let afterDisc = gross - disc;

            let tax = 0;
            if (isTax && taxRate > 0) {
                tax = (afterDisc * taxRate) / 100;
            }

            let net = afterDisc + tax;
            row.querySelector('.item-net').value = net.toFixed(2);

            updateGrandTotal();
        }

        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.item-net').forEach(el => {
                total += parseFloat(el.value) || 0;
            });
            document.getElementById('grand_total_display').innerText = 'रु ' + total.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function addNewRow() {
            let tbody = document.getElementById('items_body');
            let tr = document.createElement('tr');
            tr.className = 'item-row';
            tr.innerHTML = `
                <td>
                    <input type="text" name="items[${rowIndex}][title]" class="form-control item-title" required placeholder="Fee Description">
                    <input type="hidden" name="items[${rowIndex}][fee_category_id]" class="item-cat-id" value="">
                    <input type="hidden" name="items[${rowIndex}][fee_structure_id]" class="item-struct-id" value="">
                </td>
                <td>
                    <input type="number" step="0.01" name="items[${rowIndex}][unit_price]" class="form-control item-price" required value="0.00" oninput="calculateRow(this)">
                </td>
                <td>
                    <input type="number" step="1" min="1" name="items[${rowIndex}][quantity]" class="form-control item-qty" value="1" oninput="calculateRow(this)">
                </td>
                <td>
                    <input type="number" step="0.01" min="0" name="items[${rowIndex}][discount_amount]" class="form-control item-disc" value="0.00" oninput="calculateRow(this)">
                </td>
                <td>
                    <div class="form-check">
                        <label class="form-check-label small">
                            <input type="checkbox" name="items[${rowIndex}][is_taxable]" value="1" class="form-check-input item-tax-check" onchange="calculateRow(this)"> {{ __('Taxable') }}
                        </label>
                    </div>
                    <input type="number" step="0.01" name="items[${rowIndex}][tax_rate]" class="form-control form-control-sm item-tax-rate mt-1" value="0.00" placeholder="%" oninput="calculateRow(this)">
                </td>
                <td>
                    <input type="text" readonly class="form-control item-net font-weight-bold text-success" value="0.00">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                        <i class="icon-cross2"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
            rowIndex++;
        }

        function removeRow(button) {
            let rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                button.closest('.item-row').remove();
                updateGrandTotal();
            } else {
                alert('At least one fee item is required.');
            }
        }

        function addTemplateItem(title, amount, catId, structId, isTax, taxRate) {
            let firstRow = document.querySelector('.item-row');
            let firstTitle = firstRow.querySelector('.item-title').value;
            let targetRow;

            if (!firstTitle || firstTitle.trim() === '') {
                targetRow = firstRow;
            } else {
                addNewRow();
                let allRows = document.querySelectorAll('.item-row');
                targetRow = allRows[allRows.length - 1];
            }

            targetRow.querySelector('.item-title').value = title;
            targetRow.querySelector('.item-price').value = amount.toFixed(2);
            targetRow.querySelector('.item-cat-id').value = catId;
            targetRow.querySelector('.item-struct-id').value = structId;
            targetRow.querySelector('.item-tax-check').checked = (isTax === 1);
            targetRow.querySelector('.item-tax-rate').value = taxRate ? taxRate.toFixed(2) : '0.00';

            calculateRow(targetRow.querySelector('.item-price'));
        }
    </script>
@endsection
