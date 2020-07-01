<?php

namespace App\Traits;

trait PhoneTrait
{
              
    public function customers()
    {
        return $this->belongsTo("App\Customer");            
    }            
    public function category()
    {
        return $this->hasOne("App\Category");            
    }
}
