<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentModelGenerator extends Model
{
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'entity_user', 'user_id', 'entity_id')->withTimestamps();
    }
}
