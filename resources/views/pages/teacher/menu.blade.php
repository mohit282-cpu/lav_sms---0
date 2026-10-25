{{-- Teacher Library Menu --}}
<li class="nav-item">
    <a href="{{ route('books.index') }}" class="nav-link {{ Route::is('books.index') ? 'active' : '' }}"><i class="icon-books"></i> <span>{{ __('Library Catalogue') }}</span></a>
</li>
<li class="nav-item">
    <a href="{{ route('book_requests.index') }}" class="nav-link {{ Route::is('book_requests.index') ? 'active' : '' }}"><i class="icon-list3"></i> <span>{{ __('My Book Requests') }}</span></a>
</li>
