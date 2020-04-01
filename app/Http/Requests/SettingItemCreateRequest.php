<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class SettingItemCreateRequest extends FormRequest
{
    public function rules(Request $request)
    {
        return [
            'settings_id' => 'required',
            'name' => ['required',
                Rule::unique('setting_items')->where(function($query) use($request) {
                    return $query->whereSettingsId($request->settings_id)
                            ->whereName($request->name);
                })
            ],
            'display_name' => 'required',
            'type' => 'required'
        ];
    }

}
