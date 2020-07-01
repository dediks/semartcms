

<li class="{{ is_request_path('customer*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('customers.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('customer'))}}</span>
    </a>
</li>

<li class="{{ is_request_path('book*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('books.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('book'))}}</span>
    </a>
</li>

<li class="{{ is_request_path('category*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('categories.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('category'))}}</span>
    </a>
</li>

<li class="{{ is_request_path('phone*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('phones.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('phone'))}}</span>
    </a>
</li>



<li class="{{ is_request_path('comment*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('comments.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('comment'))}}</span>
    </a>
</li>