@section('content')
    @content([
        'title' => $title,
        'card_title' => $title,
        'card_padding' => false,
        'back' => route_admin('roles.index'),
        'breadcrumb' => $breadcrumb,
    ])
        @isset($edit)
        {!! Form::model($role, ['route' => [$action, $id]]) !!}
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

            @fieldblock([
                'label' => 'Permissions'
            ])
                <div class="mb-2">
                    <a href="#" class="check-all" data-target=".permissions-group">Check All</a> / <a href="#" class="uncheck-all" data-target=".permissions-group">Uncheck All</a>
                </div>
                <div class="permissions-group">
                    @foreach($perms as $perm)
                    <div class="custom-control custom-checkbox">
                        {!!
                            Form::checkbox('perm[]',
                                $perm->name,
                                isset($has_perms) && in_array($perm->id, $has_perms) ? true : false,
                                [
                                    'id' => $perm->name,
                                    'class' => 'custom-control-input'
                                ]
                            )
                        !!}
                        <label class="custom-control-label" for="{{ $perm->name }}">{{ $perm->name }}</label>
                    </div>
                    @endforeach
                </div>
            @endfieldblock

            @field([
                'type' => 'submit',
                'class' => 'btn-primary',
                'text' => $button
            ])
        </form>
    @endcontent
@endsection
