<?php

namespace App\Traits;

trait CommentTrait
{
              
    public function customer()
    {
        return $this->belongsTo("App\Customer");            
    }            
    public function categories()
    {
        return $this->belongsTo("App\Category");            
    }
}
