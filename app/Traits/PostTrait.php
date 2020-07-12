<?php

namespace App\Traits;

trait PostTrait
{
              
        public function author()
        {
            return $this->belongsTo("App\Author");            
        }
}
