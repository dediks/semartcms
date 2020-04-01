@section('content')
    @content([
        'title' => $title,
        'card_title' => $title,
        'card_padding' => false,
        'back' => route_admin('setting_items.list'),
        'breadcrumb' => $breadcrumb,
    ])
        @isset($edit)
        {!! Form::model($setting, ['route' => [$action, $id]]) !!}
        @else
        <form method="post" action="{{ $action }}">
        @endisset
            @csrf
            {!! isset($method) ? method_field($method) : '' !!}

            @fieldblock([
                'label' => 'Setting Group',
                'required' => true,
            ])
                <select class="form-control setting-group" name="settings_id">
                    @foreach(Setting::getGroup() as $group)
                    <option
                        data-sort="{{isset($sort[$group->id]) ? $sort[$group->id] : 1}}"
                        value="{!! $group->id !!}"
                        {{isset($setting) ? ($group->id == $setting->settings_id ? 'selected' : '') : ''}}
                    >
                        {!! $group->display_name !!}
                    </option>
                    @endforeach
                </select>
            @endfieldblock

            @field([
                'name' => 'name',
                'label' => 'Name',
                'value' => isset($setting->name) ? $setting->name : null,
                'help' => 'Use _ instead of space; e.g <code>site_name</code>',
                'type' => 'text'
            ])

            @field([
                'name' => 'display_name',
                'label' => 'Display Name',
                'value' => isset($setting->display_name) ? $setting->display_name : null,
                'type' => 'text'
            ])

            @fieldblock([
                'label' => 'Type',
                'required' => true
            ])
                <select class="form-control" name="type">
                    @foreach(FieldHelper::list() as $k => $type)
                    <option value="{!! $k !!}"{{isset($setting) ? ($k == FieldHelper::get($setting->type) ? 'selected' : '') : ''}}>{!! ucwords($k) !!}</option>
                    @endforeach
                </select>
            @endfieldblock

            @field([
                'name' => 'attrs[options]',
                'label' => 'Options',
                'help' => 'This field is used for <code>checkbox</code> type, <code>radio</code> and <code>select</code>',
                'type' => 'text',
                'value' => isset($setting->type) ? FieldHelper::getOptions($setting->type) : ''
            ])

            @fieldblock([
                'label' => 'Required?',
            ])
                @foreach([1 => 'Yes', 0 => 'No'] as $val => $lab)
                <div class="custom-control custom-radio">
                    {!!
                        Form::radio('attrs[required]',
                            $val,
                            (isset($setting) ?
                                (Setting::isRequired($setting->group->name . '.' . $setting->name) == $val ? true : false)
                                :
                                ($val == 0 ? true : false)
                            ),
                            [
                                'id' => 'req-' . $val,
                                'class' => 'custom-control-input'
                            ]
                        )
                    !!}
                    <label class="custom-control-label" for="req-{{ $val }}">{{ $lab }}</label>
                </div>
                @endforeach
            @endfieldblock

            @field([
                'name' => 'description',
                'label' => 'Description',
                'value' => isset($setting->description) ? $setting->description : null,
                'type' => 'textarea'
            ])

            @field([
                'name' => 'sort',
                'label' => 'Sort',
                'value' => isset($setting->sort) ? $setting->sort : null,
                'type' => 'number'
            ])

            @field([
                'type' => 'submit',
                'class' => 'btn-primary',
                'text' => $button
            ])
        </form>
    @endcontent
@stop

@push('scripts')
<script>
    let setting_group = $(".setting-group");
    $("[name=sort]").val(setting_group.find(":selected").attr('data-sort'));
    setting_group.change(function() {
        $("[name=sort]").val(setting_group.find(":selected").attr('data-sort'));
    });
</script>
@endpush
