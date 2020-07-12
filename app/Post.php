<?php

namespace App;

use Illuminate\Support\Facades\Gate;
use App\Traits\PostTrait;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	use PostTrait;

	protected $table = 'posts';
	protected $guarded  = [];

	public function project()
	{
		return $this->belongsTo('App\Project');
	}
	public function users()
	{
		return $this->belongsToMany('App\User');
	}
}
