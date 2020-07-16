<?php

namespace Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class InviteCreateRequest extends FormRequest
{
  public function rules()
  {
    return [
      'email' => '',
    ];
  }
}
