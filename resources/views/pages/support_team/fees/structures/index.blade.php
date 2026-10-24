@extends('layouts.master')
@section('page_title', __('Fee Structures & Schedules'))
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-bold">
                <i class="icon-cash3 mr-2 text-primary"></i> {{ __('Fee Structures & Schedules') }} ({{ $academicYear }})
            </h5>
            <div class="header-elements">
                <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#create-structure-modal">
                    <i class="icon-plus2 mr-1"></i> {{ __('Add Fee Structure') }}
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#create-category-modal">
                    <i class="icon-folder-plus mr-1"></i> {{ __('Add Fee Category') }}
                </button>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('fees.structures.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-semibold">{{ __('Academic Year (BS)') }}:</label>
                            <input type="text" name="academic_year" class="form-control" value="{{ $academicYear }}" placeholder="e.g. 2083/84 BS">
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
                <table class="table table-striped table-hover datatable-button-html5-columns">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Target Class') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Period') }}</th>
                        <th>{{ __('Due Day (BS)') }}</th>
                        <th>{{ __('Tax/VAT') }}</th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($structures as $st)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge badge-info">{{ $st->category->name ?? 'N/A' }}</span>
                            </td>
                            <td class="font-weight-semibold">{{ $st->title }}</td>
                            <td>{{ $st->my_class ? $st->my_class->name : __('All Classes') }}</td>
                            <td class="font-weight-bold text-success">{{ App\Helpers\NepaliHelper::formatNpr($st->amount) }}</td>
                            <td>
                                <span class="badge badge-light border">
                                    {{ ucfirst(str_replace('_', ' ', $st->period_type)) }}
                                </span>
                            </td>
                            <td>{{ $st->due_day ? $st->due_day . 'th' : '-' }}</td>
                            <td>
                                @if($st->is_taxable)
                                    <span class="badge badge-warning">{{ $st->tax_rate }}% Tax</span>
                                @else
                                    <span class="badge badge-light text-muted">{{ __('Exempt / 0%') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('fees.structures.destroy', $st->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this fee structure?') }}');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="icon-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                {{ __('No fee structures configured for this academic year.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Create Structure Modal --}}
    <div class="modal fade" id="create-structure-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('fees.structures.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="academic_year" value="{{ $academicYear }}">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title font-weight-bold">{{ __('Add New Fee Structure') }}</h6>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">{{ __('Title') }}: <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required placeholder="e.g. Grade 1 Monthly Tuition Fee">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">{{ __('Fee Category') }}: <span class="text-danger">*</span></label>
                                <select name="fee_category_id" class="form-control select" required>
                                    <option value="">{{ __('Select Category') }}</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->fee_type }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">{{ __('Amount (NPR)') }}: <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="amount" class="form-control" required placeholder="0.00">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">{{ __('Period Type') }}: <span class="text-danger">*</span></label>
                                <select name="period_type" class="form-control select" required>
                                    <option value="monthly">{{ __('Monthly (recurring)') }}</option>
                                    <option value="one_time">{{ __('One-time (admission/annual)') }}</option>
                                    <option value="term">{{ __('Term-wise (exam/term)') }}</option>
                                    <option value="annual">{{ __('Annual') }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">{{ __('Due Day of BS Month') }}:</label>
                                <input type="number" name="due_day" class="form-control" value="10" min="1" max="32">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">{{ __('Class (Optional - leave blank for all)') }}:</label>
                                <select name="my_class_id" class="form-control select">
                                    <option value="">{{ __('All Classes') }}</option>
                                    @foreach($classes as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">{{ __('Tax / VAT Status') }}:</label>
                                <div class="form-check mt-2">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="is_taxable" value="1" class="form-check-input" id="taxable-check">
                                        {{ __('Taxable item (Under Nepal law, basic education tuition is tax-exempt)') }}
                                    </label>
                                </div>
                                <input type="number" step="0.01" name="tax_rate" id="tax-rate-input" class="form-control mt-2" placeholder="Tax Rate % (e.g. 13)" value="0.00">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Description / Notes') }}:</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="{{ __('Optional description or remarks') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary"><i class="icon-checkmark mr-1"></i> {{ __('Save Structure') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Create Category Modal --}}
    <div class="modal fade" id="create-category-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('fees.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-dark text-white">
                        <h6 class="modal-title font-weight-bold">{{ __('Add Custom Fee Category') }}</h6>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Category Name') }}: <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Robotic Club Fee">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Unique Code') }}: <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" required placeholder="e.g. ROBOTICS" style="text-transform:uppercase">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Fee Type') }}: <span class="text-danger">*</span></label>
                            <select name="fee_type" class="form-control select" required>
                                <option value="other">{{ __('Other / Custom') }}</option>
                                <option value="tuition_monthly">{{ __('Monthly Tuition') }}</option>
                                <option value="admission">{{ __('Admission') }}</option>
                                <option value="annual">{{ __('Annual') }}</option>
                                <option value="exam">{{ __('Exam') }}</option>
                                <option value="transport">{{ __('Transportation') }}</option>
                                <option value="hostel">{{ __('Hostel') }}</option>
                                <option value="lab">{{ __('Laboratory') }}</option>
                                <option value="library">{{ __('Library') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Description') }}:</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save Category') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
