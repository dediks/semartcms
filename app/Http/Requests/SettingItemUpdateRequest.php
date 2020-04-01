<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Auth;

class SettingItemUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'settings_id' => 'required',
            'name' => ['required',
                Rule::unique('setting_items')->where(function($query) use($request) {
                    return $query->whereSettingsId($request->settings_id)
                            ->whereName($request->name);
                })->ignore($this->id)
            ],
            'display_name' => 'required',
            'type' => 'required'
        ];

        return $rules;
    }
}
