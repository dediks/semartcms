<?php

namespace App\Traits;

trait OrderTrait
{
              
        public function books()
        {
            return $this->belongsToMany("App\Book");            
        }
}
