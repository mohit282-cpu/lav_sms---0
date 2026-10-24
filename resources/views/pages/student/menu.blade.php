{{--Marksheet--}}
<li class="nav-item">
    <a href="{{ route('marks.year_select', Qs::hash(Auth::user()->id)) }}" class="nav-link {{ in_array(Route::currentRouteName(), ['marks.show', 'marks.year_selector', 'pins.enter']) ? 'active' : '' }}"><i class="icon-book"></i> {{ __('Marksheet') }}</a>
</li>

@php
    $studentRec = App\Models\StudentRecord::where('user_id', Auth::user()->id)->first();
@endphp
@if($studentRec)
<li class="nav-item">
    <a href="{{ route('attendance.student_history', $studentRec->id) }}" class="nav-link {{ Route::is('attendance.student_history') ? 'active' : '' }}"><i class="icon-user-check"></i> {{ __('My Attendance') }}</a>
</li>
@endif
