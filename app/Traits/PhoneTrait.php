<?php

namespace App\Traits;

trait PhoneTrait
{
              
        public function orang()
        {
            return $this->belongsTo("App\Orang");            
        }
}
