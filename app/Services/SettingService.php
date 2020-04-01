<?php

namespace Services;

use App\Setting;
use App\DataTables\SettingDataTable;
use Setting as SettingHelper;
use App\Events\{
    SettingGroupCreated,
    SettingGroupUpdated,
    SettingGroupDeleted,
    SettingUpdated
};

class SettingService
{
    protected $settingDataTable;

    public function __construct(SettingDataTable $settingDataTable)
    {
        $this->settingDataTable = $settingDataTable;
    }

    public function model()
    {
        return Setting::with('items');
    }

    public function dataTable(...$opts)
    {
        return $this->settingDataTable->render($opts[0]);
    }

    public function paginate($num)
    {
        return $this->model()->paginate($num);
    }

    public function getLast()
    {
        return $this->model()->orderBy('sort', 'desc')->first();
    }

    public function save($request, $setting)
    {
        $setting_name = $setting;
        $settings = $this->findByName($setting);
        $settings = $settings->items;
        $error = [];
        $store_setting = [];

        // Prepare data to store
        foreach ($settings as $setting) {
            $key = $setting->id;
            $setting = $request->{$key};

            // if value is array then do json_encode
            if(is_array($setting)) {
                $setting = json_encode($setting);
            }

            // Set value from request
            $store_setting[$key] = $setting;

            // Check required fields
            if(SettingHelper::isRequired($key)) {
                if(!isset($request->{$key}) && (SettingHelper::getType($key) !== 'image' && SettingHelper::getType($key) !== 'file')) {
                    $error[$key] = 'The ' . SettingHelper::getInfo($key)->display_name . ' field is required';
                    $store_setting[$key] = setting($key);
                }
            }

            if(SettingHelper::getType($key) == 'image') {
                if($request->hasFile($key)) {
                    if(substr($request->file($key)->getMimeType(), 0, 5) == 'image') {
                        $store_setting[$key] = $request->file($key)->getClientOriginalName();
                        $request->file($key)->storeAs(media_path() . path() . config('starter.paths.images'), $store_setting[$key], 'public');
                    }else{
                        $store_setting[$key] = setting($key);
                        $error[$key] = 'The ' . SettingHelper::getInfo($key)->display_name . ' field must be an image';
                    }
                }else{
                    if(SettingHelper::isRequired($key) && !setting($key)) {
                        $error[$key] = 'The ' . SettingHelper::getInfo($key)->display_name . ' field is required';
                    }else{
                        $store_setting[$key] = setting($key);
                    }
                }
            }

            if(SettingHelper::getType($key) == 'file') {
                if($request->hasFile($key)) {
                    $store_setting[$key] = $request->file($key)->getClientOriginalName();
                    $request->file($key)->storeAs(media_path() . path() . config('starter.paths.files'), $store_setting[$key], 'public');
                }else{
                    $store_setting[$key] = setting($key);
                }
            }

            if(SettingHelper::getType($key) == 'currency') {
                $store_setting[$key] = str_replace(".", "", $setting);
            }

        }

        if(count($error)) {
            $msg = 'Settings cannot be saved, because there are the following errors:<ul class="mb-0">';
            foreach($error as $err) {
                $msg .= '<li>' . $err .'</li>';
            }
            $msg .= '</ul>';

            return [
                'error' => true,
                'msg' => $msg
            ];
        }

        foreach($store_setting as $key => $setting) {
            setting($key, $setting);
        }

        // event(new SettingUpdated($this->findByName($setting_name), $settings));

        return true;
    }

    public function create($request)
    {
        $input = $request->all();

        $setting = $this->model()->create($input);

        // event(new SettingGroupCreated($setting));

        return $setting;
    }

    public function find($id)
    {
        return $this->model()->find($id);
    }

    public function findByName($name)
    {
        return $this->model()->whereName($name)->first();
    }

    public function findAndUpdate($id, $request)
    {
        $setting = $this->find($id);

        $input = $request->all();
        $setting->update($input);

        // event(new SettingGroupUpdated($setting));

        return $setting;
    }

    public function delete($id)
    {
        $setting = $this->find($id);

        $setting->delete();
        
        // event(new SettingGroupDeleted($setting));

        return $setting;
    }
}
