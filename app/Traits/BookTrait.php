<?php

namespace App\Traits;

trait BookTrait
{
              
        public function categories()
        {
            return $this->belongsToMany("App\Category");            
        }
}
