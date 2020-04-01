<?php

namespace App\Facades;
use App\Setting;
use App\SettingItem;
use FieldHelper;

class SettingFacade {
	public function getGroup()
    {
		$settings = Setting::orderBy('sort')->get();
		return $settings;
	}

    public function forSelect()
    {
        $items = [];
        foreach($this->getGroup() as $item) {
            $items[$item->id] = $item->display_name;
        }

        return $items;
    }

	public function get($name)
    {
        $check = $this->check($name);

        return $check->first()->value;
	}

    public function set($name, $value)
    {
        $check = $this->check($name);

        $check->update(['value' => $value]);

        return $check->first()->value;
    }

    public function check($check)
    {
        $res = [];

        if(is_numeric($check)) {
            $res = SettingItem::whereId($check);
        }else if(is_string($check)) {
            $name = $check;
            $split = explode('.', $name);
            $group = $split[0] ?? '';
            $name = $split[1] ?? '';

            $res = SettingItem::whereHas('group', function($query) use($group) {
                $query->whereName($group);
            })->whereName($name);
        }

        if((is_array($check) && !count($check)) || (is_object($check) && !$check->count())) {
            throw new \Exception("Setting not found", 1);
        }

        return $res;
    }

	public function getType($name)
    {
        $check = $this->check($name);

		return FieldHelper::get($check->first()->type);
	}

	public function isRequired($name)
    {
        $check = $this->check($name);

        $type = $check->first()->type;

		return (FieldHelper::getRequired($type) == 'required' ? true : false);
	}

	public function getInfo($name)
    {
        $check = $this->check($name);

        return $check->first();
	}

	public function getFirst()
    {
		$setting = Setting::orderBy('sort')->first();
		return $setting;
	}
}
