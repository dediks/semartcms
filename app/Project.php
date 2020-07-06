<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded  = [];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function entity()
    {
        return $this->hasMany('App\Project');
    }
}
