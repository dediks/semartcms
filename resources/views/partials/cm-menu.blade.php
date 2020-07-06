









































<li class="{{ is_request_path('book*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('books.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('book'))}}</span>
    </a>
</li>