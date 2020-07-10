<?php

namespace App;

use Illuminate\Support\Facades\Gate;
use App\Traits\{Name}Trait;

use Illuminate\Database\Eloquent\Model;

class {Name} extends Model
{
	use {Name}Trait;

	protected $table = '{plural}';
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
