<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Services\SettingService;
use Requests\{
	SettingCreateRequest,
	SettingUpdateRequest
};
use Setting;

class SettingController extends Controller
{
	protected $settingService;

	public function __construct(SettingService $setting)
	{
		$this->settingService = $setting;
	}

	public function index()
	{
		$roles = Role::orderBy('name')->get();

		return view("settings.index", ["roles" => $roles]);
	}

	public function save(Request $request, $setting)
	{
	}

	public function list()
	{
	}

	public function create()
	{
	}

	public function store(SettingCreateRequest $request)
	{
	}

	public function edit($id)
	{
	}

	public function update(SettingUpdateRequest $request, $id)
	{
	}

	public function destroy($id)
	{
	}
}
