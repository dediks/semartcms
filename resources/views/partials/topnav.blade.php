<form class="form-inline mr-auto" action="{{ route('users.index') }}">
  <ul class="navbar-nav mr-3">
    @if (request()->session()->has('project'))
    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>      
    @endif
  </ul>
</form>
<ul class="navbar-nav navbar-right">
  <li class="dropdown"><div href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
    <img alt="image" src="{{ Auth::user()->avatarlink ?? '' }}" class="rounded-circle mr-1">
    <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name ?? ''}}</div></div>
    <div class="dropdown-menu dropdown-menu-right">
      <div class="dropdown-title">Welcome, {{ Auth::user()->name ?? ''}}</div>
      <a href="{{ Auth::user()->profilelink ?? ''}}" class="dropdown-item has-icon">
        <i class="far fa-user"></i> Profile Settings
      </a>
      <div class="dropdown-divider"></div>
      <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </li>
</ul>
