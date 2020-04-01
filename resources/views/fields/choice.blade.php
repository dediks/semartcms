@foreach($options as $option)
    @php 
    	$id = uniqid(); 
    @endphp

    <div class="custom-control custom-{{ $type }}">
		<input 
			id="{{ $id }}" 
			class="custom-control-input" 
			type="{{ $type }}" 
			name="{{ $name }}" 
			value="{{ $option }}" 
			{{ $option == $value ? 'checked' : '' }}
		>
	    <label class="custom-control-label" for="{{ $id }}">{{ $option }}</label>
	</div>

@endforeach