{{--Marksheet--}}
<li class="nav-item">
    <a href="{{ route('marks.year_selector', Qs::hash(Auth::user()->id)) }}" class="nav-link {{ in_array(Route::currentRouteName(), ['marks.show', 'marks.year_selector', 'pins.enter']) ? 'active' : '' }}"><i class="icon-book"></i> {{ __('Marksheet') }}</a>
</li>

@php
    $studentRec = App\Models\StudentRecord::where('user_id', Auth::user()->id)->first();
@endphp
@if($studentRec)
<li class="nav-item">
    <a href="{{ route('attendance.student_history', $studentRec->id) }}" class="nav-link {{ Route::is('attendance.student_history') ? 'active' : '' }}"><i class="icon-user-check"></i> {{ __('My Attendance') }}</a>
</li>
@endif

{{--Library--}}
<li class="nav-item">
    <a href="{{ route('books.index') }}" class="nav-link {{ Route::is('books.index') ? 'active' : '' }}"><i class="icon-books"></i> {{ __('Library Catalogue') }}</a>
</li>
<li class="nav-item">
    <a href="{{ route('book_requests.index') }}" class="nav-link {{ Route::is('book_requests.index') ? 'active' : '' }}"><i class="icon-list3"></i> {{ __('My Book Requests') }}</a>
</li>
