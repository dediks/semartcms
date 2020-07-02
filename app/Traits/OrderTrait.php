<?php

namespace App\Traits;

trait OrderTrait
{
              
        public function customer()
        {
            return $this->belongsTo("App\Customer");            
        }
}
