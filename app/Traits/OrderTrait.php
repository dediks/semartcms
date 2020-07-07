<?php

namespace App\Traits;

trait OrderTrait
{

    public function books()
    {
        return $this->belongsToMany("App\Book");
    }
    public function customer()
    {
        return $this->belongsTo("App\Customer");
    }
}
