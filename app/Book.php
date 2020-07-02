<?php

namespace App;
use App\Traits\BookTrait;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	use BookTrait;

	protected $table = 'books';
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
