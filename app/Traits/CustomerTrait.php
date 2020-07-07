<?php

namespace App\Traits;

trait CustomerTrait
{

    public function orders()
    {
        return $this->hasMany("App\Order");
    }
}
