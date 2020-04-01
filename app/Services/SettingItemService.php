<?php

namespace Services;

use App\SettingItem;
use App\Setting;
use App\DataTables\SettingItemDataTable;
use App\Events\{
    SettingItemCreated,
    SettingItemUpdated,
    SettingItemDeleted
};

class SettingItemService
{
    protected $settingItemDataTable;

    public function __construct(SettingItemDataTable $settingItemDataTable)
    {
        $this->settingItemDataTable = $settingItemDataTable;
    }

    public function model()
    {
        return SettingItem::with('group');
    }

    public function dataTable(...$opts)
    {
        return $this->settingItemDataTable->render($opts[0]);
    }

    public function getSort()
    {
        $sort = $this->model()->orderBy('sort', 'asc')->get();

        $sort_arr = [];
        foreach($sort as $s)
        {
            $sort_arr[$s->settings_id] = $s->sort + 1;
        }
        $sort = $sort_arr;

        return $sort;
    }

    public function paginate($num)
    {
        return $this->model()->paginate($num);
    }

    public function find($id)
    {
        return $this->model()->find($id);
    }

    public function create($request)
    {
        $input = $request->all();
        $input['type'] = $input['type'] . "|" . (@count($input['attrs']['options']) ? $input['attrs']['options'] : 'null') . "|" . ($input['attrs']['required'] == 1 ? 'required' : 'not-required');

        $setting = $this->model()->create($input);

        event(new SettingItemCreated($setting));

        return $setting;
    }

    public function findAndUpdate($request, $id)
    {
        $input = $request->all();

        $input['type'] = $input['type'] . "|" . (@count($input['attrs']['options']) ? $input['attrs']['options'] : 'null') . "|" . ($input['attrs']['required'] == 1 ? 'required' : 'not-required');

        $setting = $this->find($id);
        $setting->update($input);

        event(new SettingItemUpdated($setting));

        return $setting;
    }

    public function delete($id)
    {
        $setting = $this->find($id);

        $setting->delete();

        event(new SettingItemDeleted($setting));

        return $setting;
    }
}
