<?php

namespace App\Traits;

trait CategoryTrait
{

    public function books()
    {
        return $this->belongsToMany("App\Book");
    }
}
