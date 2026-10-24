@extends('layouts.master')
@section('page_title', __('Student Fee Ledger'))
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-bold">
                <i class="icon-history mr-2 text-primary"></i> {{ __('Student Fee Ledger & Account Statements') }}
            </h5>
        </div>

        <div class="card-body">
            <div class="alert alert-info">
                <i class="icon-info22 mr-1"></i> {{ __('Select a class to browse students and view their official fee transaction ledger and statements.') }}
            </div>

            <form method="GET" action="{{ route('fees.ledger.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Select Class') }}:</label>
                            <select name="my_class_id" class="form-control select" onchange="this.form.submit()" required>
                                <option value="">{{ __('Select Class') }}</option>
                                @foreach($classes as $c)
                                    <option value="{{ $c->id }}" {{ $selected_class_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            @if($selected_class_id)
                <div class="table-responsive">
                    <table class="table table-striped table-hover datatable-button-html5-columns">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Photo') }}</th>
                            <th>{{ __('Student Name') }}</th>
                            <th>{{ __('Admission No') }}</th>
                            <th>{{ __('Section') }}</th>
                            <th class="text-center">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($students as $sr)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img class="rounded-circle" style="height: 35px; width: 35px;" src="{{ $sr->user->photo }}" alt="photo"></td>
                                <td class="font-weight-semibold">{{ $sr->user->name }}</td>
                                <td>{{ $sr->adm_no }}</td>
                                <td>{{ $sr->section->name ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('fees.ledger.show', $sr->user_id) }}" class="btn btn-sm btn-primary">
                                        <i class="icon-eye mr-1"></i> {{ __('View Fee Ledger') }}
                                    </a>
                                    <a href="{{ route('fees.ledger.print', $sr->user_id) }}" target="_blank" class="btn btn-sm btn-outline-secondary ml-1">
                                        <i class="icon-printer"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    {{ __('No students found in this class.') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection
