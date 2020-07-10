<?php

namespace Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\DataTables\PermissionDataTable;
use App\Events\{
    PermissionCreated,
    PermissionUpdated,
    PermissionDeleted
};

class PermissionService
{

    protected $permissionDataTable;

    public function __construct(PermissionDataTable $permissionDataTable)
    {
        $this->permissionDataTable = $permissionDataTable;
    }

    public function getTableName()
    {
        return $this->model()->getTable();
    }

    public function model()
    {
        return new Permission;
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
        return $this->permissionDataTable->render($opts[0]);
    }

    public function create($request)
    {
        $input = $request->all();

        $permission = $this->model()->make([
            'name' => $input['name']
        ]);

        $permission->saveOrFail();

        event(new PermissionCreated($permission));

        return $permission;
    }

    public function findAndUpdate($request, $id)
    {
        $permission = $this->find($id);
        $old = $this->find($id);

        $permission->update($request->only(['name', 'guard']));

        event(new PermissionUpdated($permission, $old));

        $permission->syncPermissions($request->perm);
    }

    public function destroy($id)
    {
        $permission = $this->find($id);

        $permission->delete();

        event(new PermissionDeleted($permission));

        return $permission;
    }
}
