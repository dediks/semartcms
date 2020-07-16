<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded  = [];

    public function hasUser($user)
    {
        return $this->users->contains($user);
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function entities()
    {
        return $this->hasMany('App\EntityStore', 'project_id', 'id');
    }
}
