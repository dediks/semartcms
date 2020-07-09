<?php

namespace App;

use Laravel\Scout\Searchable;
use App\Traits\TestTrait;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
	use TestTrait;

	protected $table = 'tests';
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
