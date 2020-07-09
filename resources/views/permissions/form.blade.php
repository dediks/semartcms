@section('content')
    @content([
        'title' => $title,
        'card_title' => $title,
        'card_padding' => false,
        'back' => route_admin('permission.index'),
        'breadcrumb' => $breadcrumb,
    ])
        @isset($edit)
        {!! Form::model(['route' => [$action, $id]]) !!}
        @else
        <form method="post" action="{{ $action }}">
        @endisset
            @csrf
            {!! isset($method) ? method_field($method) : '' !!}

            @field([
                'label' => 'Name',
                'name' => 'name',
                'type' => 'text',
            ])

            @field([
                'type' => 'submit',
                'class' => 'btn-primary',
                'text' => $button
            ])
        </form>
    @endcontent
@endsection
