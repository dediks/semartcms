<?php

namespace App\Traits;

trait BookTrait
{
              
        public function orders()
        {
            return $this->belongsToMany("App\Order");            
        }
}
