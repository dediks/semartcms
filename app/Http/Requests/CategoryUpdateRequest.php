<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
                    'slug' => '| unique:categories,slug'.$this->id,
                    'image' => '',
        ];
    }
}
