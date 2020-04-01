<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SettingCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:settings,name',
            'display_name' => 'required'
        ];
    }

}
