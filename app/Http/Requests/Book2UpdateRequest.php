<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;

class Book2UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
                    'title' => '',
        ];
    }
}
