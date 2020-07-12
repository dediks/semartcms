<?php

namespace App;

use Illuminate\Support\Facades\Gate;
use App\Traits\AuthorTrait;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	use AuthorTrait;

	protected $table = 'authors';
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
