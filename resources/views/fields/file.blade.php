{!! Form::{$type}($name, $attrs) !!}

@isset($value)
	<div class="form-text">	
		@if($type_alias == 'image')
			Current Image: <a href="{!! images($value) !!}" target="_blank">Open</a>
		@else
			Current File: <a href="{!! files($value) !!}" target="_blank">Open</a>
		@endif
	</div>
@endisset