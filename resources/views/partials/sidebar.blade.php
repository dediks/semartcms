<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ route('dashboard.index') }}" class="d-inline">
      @isset(session('project')["name"])
        <div>
          {{ session('project')["name"] }}        
        </div>
      @endisset
    </a>
  </div>
  <ul class="sidebar-menu">
    @include('partials.menu')
  </ul>
</aside>
