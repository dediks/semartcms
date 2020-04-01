@php 
    if(!isset($horizontal)) $horizontal = true;
@endphp

<div class="form-group {!! (isset($horizontal) && $horizontal ? 'row mb-4 ' : '') . (isset($hidden) ? ' d-none' : '') !!}">
    <label
	    {!! isset($attrs) ? 'for="' . $attrs['id'] . '"' : '' !!}
    	class="{!! (isset($horizontal) && $horizontal ? 'col-form-label text-md-right col-12 col-md-3 col-lg-3 ' : '') . (isset($required) ? 'required' : '') !!}"
    >
    	{!! $label ?? '' !!}
	</label>

	@if(isset($horizontal) && $horizontal)
	    <div class="col-sm-12 col-md-7">
	@endif

        @empty($slot)
    		{{-- Include the input field --}}
    		@include($view)
        @else
            {!! $slot !!}
        @endempty

        @isset($help)
        <div class="form-text text-muted">
            {!! $help !!}
        </div>
        @endisset

	@if(isset($horizontal) && $horizontal)
		</div>
	@endif
</div>

@if(isset($css))
    @push('css-plugins')
        @foreach($css as $c)
            <link rel="stylesheet" href="{{ $c }}">
        @endforeach
    @endpush
@endif

@if(isset($js))
    @push('js-plugins')
        @foreach($js as $c)
            <script src="{{ $c }}"></script>
        @endforeach
    @endpush
@endif

@if(isset($script))
    @push('script')
        <script>
            {!! $script !!}
        </script>
    @endpush
@endif