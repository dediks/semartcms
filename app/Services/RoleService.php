<?php

namespace Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\DataTables\RoleDataTable;
use App\Events\{
    RoleCreated,
    RoleUpdated,
    RoleDeleted
};

class RoleService
{

    protected $roleDataTable;

    public function __construct(RoleDataTable $roleDataTable)
    {
        $this->roleDataTable = $roleDataTable;
    }

    public function model()
    {
        return new Role;
    }

    public function all()
    {
        return $this->model()->all();
    }

    public function find($id)
    {
        return $this->model()->find($id);
    }

    public function dataTable(...$opts)
    {
        return $this->roleDataTable->render($opts[0]);
    }

    public function create($request)
    {
        $input = $request->all();

        // dd($input);

        $role = $this->model()->create([
            'name' => $input['name']
        ]);

        event(new RoleCreated($role));

        $role->givePermissionTo($input['perm']);

        return $role;
    }

    public function findAndUpdate($request, $id)
    {
        $role = $this->find($id);
        $old = $this->find($id);

        $role->update($request->only(['name', 'guard']));

        event(new RoleUpdated($role, $old));

        $role->syncPermissions($request->perm);
    }

    public function destroy($id)
    {
        $role = $this->find($id);

        $role->delete();

        event(new RoleDeleted($role));

        return $role;
    }
}
