<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
                    'username' => 'required| unique:customers,username',
                    'remember_token' => '',
                    'email' => 'required| unique:customers,email',
                    'password' => 'required',
                    'name' => 'required',
                    'address' => '',
                    'phone' => '',
                    'avatar' => '',
        ];
    }
}
