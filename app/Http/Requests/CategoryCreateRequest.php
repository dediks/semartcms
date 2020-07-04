<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
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
                    'slug' => '| unique:categories,slug',
                    'image' => '',
        ];
    }
}
