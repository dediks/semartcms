<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
                    'username' => 'required| unique:customers,username'.$this->id,
                    'remember_token' => '',
                    'email' => 'required| unique:customers,email'.$this->id,
                    'roles' => '',
                    'address' => '',
                    'phone' => '',
                    'avatar' => '',
                    'status' => '',
        ];
    }
}
