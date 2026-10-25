{{--My Children--}}
<li class="nav-item">
    <a href="{{ route('my_children') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['my_children']) ? 'active' : '' }}"><i class="icon-users4"></i> {{ __('My Children') }}</a>
</li>

{{-- Library Catalogue --}}
<li class="nav-item">
    <a href="{{ route('books.catalogue') }}" class="nav-link {{ Route::is('books.catalogue') ? 'active' : '' }}"><i class="icon-books"></i> {{ __('Library Catalogue') }}</a>
</li>