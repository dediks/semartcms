<?php

namespace App\Traits;

trait AuthorTrait
{
              
        public function posts()
        {
            return $this->hasMany("App\Post");            
        }
}
