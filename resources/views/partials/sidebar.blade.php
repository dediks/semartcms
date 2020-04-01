<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="index.html">St</a>
  </div>
  <ul class="sidebar-menu">
    @include('partials.menu')
      {{-- <li class="{{ is_request_path('customer*') ? ' active' : '' }}"><a class="nav-link" href="{{ route('customers.index') }}"><i class="fas fa-user"></i> <span>Customer</span></a></li> --}}
    </ul>
</aside>
