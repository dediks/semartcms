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
            
                    'name' => '',
                    'username' => 'required| unique:customers,username',
                    'remember_token' => '',
                    'email' => 'required| unique:customers,email',
                    'roles' => '',
                    'address' => '',
                    'phone' => '',
                    'avatar' => '',
                    'status' => '',
        ];
    }
}
