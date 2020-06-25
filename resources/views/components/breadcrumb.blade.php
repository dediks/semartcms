<div class="breadcrumb-item">
	<a href="@routeAdmin('dashboard.index')">Dashboard</a> 
</div>

@if($segments)
	@foreach($segments as $key => $segment)
		<div class="breadcrumb-item">
			@if($key && !is_numeric($key))
			<a href="{{ $key }}">{{ $segment }}</a>
			@else
		{{ $segment }}
			@endif
		</div>
	@endforeach
@endif