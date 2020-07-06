<?php

namespace App\Traits;

trait BookTrait
{
              
        public function categories()
        {
            return $this->belongsToMany("App\Category");            
        }            
        public function orders()
        {
            return $this->belongsToMany("App\Order");            
        }
}
