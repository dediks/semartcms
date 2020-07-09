<li class="menu-header">Dashboard</li>
<li class="{{ is_request_path('dashboard*') ? ' active' : '' }}"><a class="nav-link" href="{{ route('dashboard.index') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>

@can("Manage Content Model")
<li class="menu-header">Content Model</li>
<li class="{{ is_request_path('content-model*') ? ' active' : '' }}"><a class="nav-link" href="{{ route('content_model.layout') }}"><i class="fas fa-cube"></i> <span>Builder</span></a></li>
<li class="{{ is_request_path('content-model*') ? ' active' : '' }}"><a class="nav-link" href="{{ route('content_model.index') }}"><i class="fas fa-tasks"></i> <span>Manage</span></a></li>

<li class="menu-header">Master</li>
<li class="{{ is_request_path('users*') ? ' active' : '' }}"><a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-user"></i> <span>Users</span></a></li>
<li class="{{ is_request_path('roles*') ? ' active' : '' }}"><a class="nav-link" href="{{ route('roles.index') }}"><i class="fas fa-user-tag"></i> <span>Roles</span></a></li>
@endcan

<li class="menu-header">Menu</li>

@include('partials.cm-menu')

<li class="menu-header">API's</li>
<li class="{{ is_request_path('graphql-playground*') ? ' active' : '' }}"><a class="nav-link" href="{{ route('graphql-playground') }}"><i class="fas fa-user"></i> <span>Playground</span></a></li>
<li class="{{ is_request_path('roles*') ? ' active' : '' }}"><a class="nav-link" href="{{ route('roles.index') }}"><i class="fas fa-gear"></i> <span>Settings</span></a></li>

<li class="{{ is_request_path('extensions*') ? ' active' : '' }}"><a class="nav-link" href="{{ route('extension.index') }}"><i class="fas fa-tasks"></i> <span>Extension</span></a></li>