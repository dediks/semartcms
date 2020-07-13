<?php

namespace App;

use Illuminate\Support\Facades\Gate;
use App\Traits\CategoryTrait;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use CategoryTrait;

	protected $table = 'categories';
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
