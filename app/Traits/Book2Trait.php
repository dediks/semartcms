<?php

namespace App\Traits;

trait Book2Trait
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
