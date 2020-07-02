<?php

namespace Modules\ContentModelGenerator\Entities;

use Illuminate\Database\Eloquent\Model;

class EntityStore extends Model
{
    protected $table = 'entity_stores';

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'entity_user', 'user_id', 'entity_id');
    }
}
