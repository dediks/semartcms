





<li class="{{ is_request_path('book*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('books.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('book'))}}</span>
    </a>
</li>





<li class="{{ is_request_path('customer*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('customers.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('customer'))}}</span>
    </a>
</li>

<li class="{{ is_request_path('category*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('categories.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('category'))}}</span>
    </a>
</li>

<li class="{{ is_request_path('order*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('orders.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('order'))}}</span>
    </a>
</li>

<li class="{{ is_request_path('test*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('tests.index') }}">
    <i class="fas fa-circle"></i><span>{{ucfirst(trans('test'))}}</span>
    </a>
</li>