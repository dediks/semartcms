<?php

namespace Services;

use App\User;

class InviteService
{
  public function isEmailExists($email)
  {
    return User::where('email',  $email)->exists();
  }
}
