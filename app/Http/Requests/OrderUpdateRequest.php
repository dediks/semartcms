<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
                    'total_price' => '',
                    'invoice_number' => '',
                    'status' => '',
        ];
    }
}
