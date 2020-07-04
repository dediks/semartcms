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
            
                    'invoice_number' => '',
                    'total_price' => '',
                    'status' => '',
        ];
    }
}
