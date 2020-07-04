<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookCreateRequest extends FormRequest
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
            'cover' => '',
            'price' => 'required',
            'slug' => 'required| unique:books,slug',
            'author' => '',
            'description' => '',
            'publisher' => '',
            'views' => '',
            'stock' => '',
        ];
    }
}
