<?php

namespace App\Traits;

trait OrangTrait
{
              
        public function phone()
        {
            return $this->hasOne("App\Phone");            
        }            
        public function pesanans()
        {
            return $this->hasMany("App\Pesanan");            
        }
}
