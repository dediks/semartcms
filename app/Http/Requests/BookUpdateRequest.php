<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
                    'title' => 'required',
                    'slug' => 'required| unique:books,slug'.$this->id,
                    'description' => '',
                    'author' => '',
                    'publisher' => '',
                    'price' => 'required',
                    'views' => '',
                    'stock' => '',
                    'status' => '',
                    'cover' => '',
        ];
    }
}
