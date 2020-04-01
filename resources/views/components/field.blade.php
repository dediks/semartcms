<div class="form-group {{!isset($default_class) ? 'row mb-4' : ''}}{{ isset($hidden) ? ' d-none' : '' }}">
    <label class="col-form-label text-md-right {{!isset($default_class) ? 'col-12 col-md-3 col-lg-3' : ''}}{{ isset($required) ? ' required' : '' }}">{{ $label ?? '' }}</label>

    @if(!isset($default_class))
    <div class="col-sm-12 col-md-7">
    @endif
        @isset($type)
            @php 
                $attrs = [
                    'class' => 'form-control' . (isset($class) ? ' ' . $class : ''),
                    'placeholder' => $placeholder ?? '',
                ] + ($attrs ?? []); 
            @endphp

            @switch($type)
                @case('password')
                    {{ Form::password($name ?? '', $attrs) }}
                    @break

                @case('select')
                    {{ Form::select($name ?? '', $data, $selected ?? null, $attrs) }}
                    @break

                @case('button')
                    <button class="btn{{ isset($class) ? ' ' . $class : '' }}">{{ $text }}</button>
                    @break

                @case('code')
                    {{ Form::textarea($name ?? '', $value ?? null, array_merge($attrs, ['class' => ($attrs['class'] . ' code')])) }}
                    @break

                @case('datepicker')
                    {{ Form::text($name ?? '', $value ?? null, array_merge($attrs, ['class' => ($attrs['class'] . ' datepicker')])) }}
                    @break

                @case('timepicker')
                    {{ Form::text($name ?? '', $value ?? null, array_merge($attrs, ['class' => ($attrs['class'] . ' timepicker')])) }}
                    @break

                @case('currency')
                    {{ Form::text($name ?? '', $value ?? null, array_merge($attrs, ['class' => ($attrs['class'] . ' currency')])) }}
                    @break

                @default
                    {{ Form::{$type}($name ?? '', $value ?? null, $attrs) }}
            @endswitch

            @isset($help)
            <div class="form-text">
                {{ $help }}
            </div>
            @endisset
        @endisset

        @isset($slot)
        {{ $slot }}
        @endisset
    @if(!isset($default_class))
    </div>
    @endif
</div>
