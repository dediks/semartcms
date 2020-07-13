<?php

namespace App;

use Illuminate\Support\Facades\Gate;
use App\Traits\Book2Trait;

use Illuminate\Database\Eloquent\Model;

class Book2 extends Model
{
	use Book2Trait;

	protected $table = 'book2s';
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
