<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\SettingItemService;
use Requests\{
    SettingItemCreateRequest,
    SettingItemUpdateRequest
};
use Session;

class SettingItemController extends Controller
{

    protected $settingItemService;

    public function __construct(SettingItemService $settingItem)
    {
        $this->settingItemService = $settingItem;
    }

	public function index()
    {
		return view('setting_items.index');
	}

	public function list()
    {
    	return $this->settingItemService->dataTable('setting_items.list');
	}

	public function create()
    {
        $sort = $this->settingItemService->getSort();

		return view('setting_items.create', compact('sort'));
	}

	public function store(SettingItemCreateRequest $request)
    {
		$this->settingItemService->create($request);

		flash('Setting group created successfully')->success();

		return redirect(route_admin('setting_items.list'));
	}

	public function edit($id)
    {
		$setting = $this->settingItemService->find($id);

		return view('setting_items.edit', compact('setting', 'id'));
	}

	public function update(SettingItemUpdateRequest $request, $id)
    {
		$setting = $this->settingItemService->findAndUpdate($request, $id);

		flash('Setting group updated successfully')->success();

		return redirect(route_admin('setting_items.list'));
	}

	public function destroy($id)
    {
		$this->settingItemService->delete($id);

		flash('Setting group deleted successfully')->success();

		return redirect(route_admin('setting_items.list'));
	}
}
