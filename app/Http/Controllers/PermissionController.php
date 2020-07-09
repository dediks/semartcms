<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Permission;
use Illuminate\Http\Request;
use Services\PermissionService;

class PermissionController extends Controller
{
    public $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return $this->permissionService->dataTable('permissions.index');
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(PermissionCreateRequest $request)
    {
        $this->permissionService->create($request);

        flash('Permission created successfully')->success();

        return redirect(route_admin('permission.index'));
    }

    public function edit($id)
    {

        return view('permissions.edit', compact('id'));
    }

    public function update(PermissionUpdateRequest $request, $id)
    {
        $permission = $this->permissionService->findAndUpdate($request, $id);

        flash('Permission updated successfully')->success();

        return redirect(route_admin('permission.index'));
    }

    public function destroy($id)
    {
        $permission = $this->permissionService->destroy($id);

        flash('Permission deleted successfully')->success();

        return redirect(route_admin('permission.index'));
    }
}
