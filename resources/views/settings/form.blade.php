@section('content')
    @content([
        'title' => $title,
        'card_title' => $title,
        'card_padding' => false,
        'back' => route_admin('settings.index'),
        'breadcrumb' => $breadcrumb,
    ])
        @isset($edit)
        {!! Form::model($setting, ['route' => [$action, $id]]) !!}
        @else
        <form method="post" action="{{ $action }}">
        @endisset
            @csrf
            {!! isset($method) ? method_field($method) : '' !!}

            @field([
                'required' => true,
                'label' => 'Name',
                'name' => 'name',
                'type' => 'text',
                'help' => 'Use _ instead of space',
                'value' => isset($setting->name) ? $setting->name : ''
            ])

            @field([
                'required' => true,
                'label' => 'Display Name',
                'name' => 'display_name',
                'type' => 'text',
                'value' => isset($setting->display_name) ? $setting->display_name : ''
            ])

            @field([
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'value' => isset($setting->description) ? $setting->description : ''
            ])

            @field([
                'label' => 'Sort',
                'name' => 'sort',
                'type' => 'number',
                'value' => isset($setting->sort) ? $setting->sort : $sort
            ])

            @field([
                'type' => 'submit',
                'class' => 'btn-primary',
                'text' => $button
            ])
        </form>
    @endcontent
@stop
