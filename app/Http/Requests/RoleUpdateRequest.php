<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class RoleUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255|unique:roles,name,' . $this->id,
            'perm' => 'required',
        ];
    }
}
