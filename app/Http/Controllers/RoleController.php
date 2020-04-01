<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\RoleService;
use App\Http\Requests\{
    RoleCreateRequest,
    RoleUpdateRequest
};
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
	public $roleService;

	public function __construct(RoleService $roleService)
	{
		$this->roleService = $roleService;
	}

	public function index()
	{
        return $this->roleService->dataTable('roles.index');
	}

	public function create()
	{
        $perms = Permission::all();
		return view('roles.create', compact('perms'));
	}

    public function store(RoleCreateRequest $request)
    {
        $this->roleService->create($request);

        flash('Role created successfully')->success();

        return redirect(route_admin('roles.index'));
    }

    public function edit($id)
    {
        $perms = Permission::all();
        $role = $this->roleService->find($id);

        /**
         * Get all permissions inside the role
         */
        $has_perms = [];
        foreach($role->getAllPermissions() as $perm) {
            $has_perms[] = $perm->id;
        }

        return view('roles.edit', compact('perms', 'id', 'role', 'has_perms'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $role = $this->roleService->findAndUpdate($request, $id);

        flash('Role updated successfully')->success();

        return redirect(route_admin('roles.index'));
    }

    public function destroy($id)
    {
        $role = $this->roleService->destroy($id);

        flash('Role deleted successfully')->success();

        return redirect(route_admin('roles.index'));
    }
}
