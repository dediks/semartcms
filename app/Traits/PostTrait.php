<?php

namespace App\Traits;

trait PostTrait
{
              
        public function comments()
        {
            return $this->hasMany("App\Comment");            
        }            
        public function Author()
        {
            return $this->belongsTo("App\Author");            
        }
}
