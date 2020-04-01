<div class="input-group">
	{!! Form::{$type}($name, $value, $attrs) !!}
	<button type="button" class="midia-toggle-{{$directory}} btn btn-primary" data-input="{{ $attrs['id'] }}">Select File</button>
</div>

@push('css-plugins')
	{!! midia_css() !!}
@endpush

@push('js-plugins')
	{!! midia_js() !!}
@endpush

@push('scripts')
	<script>
		$(".midia-toggle-{{$directory}}").midia({
			base_url: '{{url('')}}',
			directory_name: '{{ $directory }}',
			file_name: 'fullname'
		});
	</script>
@endpush