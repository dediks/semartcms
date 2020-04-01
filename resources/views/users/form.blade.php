@section('content')
    @content([
        'title' => $title,
        'card_title' => $title,
        'card_padding' => false,
        'back' => route('users.index'),
        'breadcrumb' => $breadcrumb,
    ])
        @isset($edit)
        {!! Form::model($user, ['route' => [$action, $id], 'enctype' => 'multipart/form-data']) !!}
        @else
        <form method="post" action="{{ $action }}" enctype="multipart/form-data">
        @endisset
            {!! isset($method) ? method_field($method) : '' !!}
            {!! csrf_field() !!}

            @field([
                'label' => 'Name',
                'name' => 'name',
                'type' => 'text'
            ])
            @field([
                'label' => 'Email',
                'name' => 'email',
                'type' => 'text'
            ])
            @field([
                'label' => 'Avatar',
                'name' => 'avatar',
                'type' => 'image',
                'value' => $user->avatar ?? null
            ])
            @field([
                'label' => 'Password',
                'name' => 'password',
                'type' => 'password',
                'help' => (isset($edit) ? 'Ignore if not changed' : '')
            ])
            @field([
                'label' => 'Password Confirmation',
                'name' => 'password_confirmation',
                'type' => 'password'
            ])
            @field([
                'label' => 'Role',
                'name' => 'role[]',
                'type' => 'select',
                'options' => Role::forSelect(),
                'value' => optional(optional(isset($user) ? $user : '')->roles())->pluck('id'),
                'attrs' => [
                    'multiple' => true,
                    'style' => 'min-height: 100px;'
                ],
                'help' => 'Press CTRL+Click to select multiple roles'
            ])

            @fieldblock
                <div class="custom-control custom-checkbox">
                    <input id="verify" class="custom-control-input" type="checkbox" name="verify" {{ !isset($edit) ? 'checked' : '' }}>
                    <label for="verify" class="custom-control-label">Send verification email to this user</label>
                </div>
            @endfieldblock

            @field([
                'type' => 'submit',
                'class' => 'btn-primary',
                'text' => $button,
                'label' => false
            ])
        </form>
    @endcontent
@endsection
