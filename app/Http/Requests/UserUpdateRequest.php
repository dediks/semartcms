<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:255|min:3',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'avatar' => 'nullable|image',
            'password' => 'nullable|min:5|confirmed'
        ];

        return $rules;
    }
}
