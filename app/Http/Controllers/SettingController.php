<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\SettingService;
use Requests\ {
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

	public function index($setting=false)
    {
		if($setting == false) {
			$setting = Setting::getFirst();


			return redirect(route('settings.index', $setting->name));
		}

		$setting = $this->settingService->findByName($setting);

		if(!$setting) {
			return abort(404);
		}

		return view('settings.index', compact('setting'));
	}

    public function save(Request $request, $setting)
    {

        $save = $this->settingService->save($request, $setting);

        if(is_array($save) && $save['error']) {
            flash($save['msg'])->error();

            return redirect()->back();
        }

        flash('Setting updated successfully')->success();

        return redirect()->back();
    }

	public function list() {
        return $this->settingService->dataTable('settings.list');
	}

	public function create() {
		$sort = $this->settingService->getLast();
		$sort = optional($sort)->sort + 1;

		return view('settings.create', compact('sort'));
	}

	public function store(SettingCreateRequest $request) {
		$this->settingService->create($request);

		flash('Setting group created successfully')->success();

		return redirect(route('settings.list'));
	}

	public function edit($id) {
		$setting = $this->settingService->find($id);

		return view('settings.edit', compact('setting', 'id'));
	}

	public function update(SettingUpdateRequest $request, $id) {
		$setting = $this->settingService->findAndUpdate($id, $request);

		flash('Setting group updated successfully')->success();

		return redirect(route('settings.list'));
	}

	public function destroy($id) {
		$this->settingService->delete($id);

		flash('Setting group deleted successfully')->success();

		return redirect(route('settings.list'));
	}
}
