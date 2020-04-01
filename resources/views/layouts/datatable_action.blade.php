    <a href="{{ route($route . '.edit', $model->id) }}" class='btn btn-secondary'>
        Edit
    </a>

    @deletebutton([
        'id' => $model->id,
        'route' => route_admin($route . '.destroy', $model->id)
    ])
        <i class="fa fa-trash"></i>
    @enddeletebutton
