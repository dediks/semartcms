<?php

namespace App;

use Illuminate\Support\Facades\Gate;
use App\Traits\OrangTrait;

use Illuminate\Database\Eloquent\Model;

class Orang extends Model
{
	use OrangTrait;

	protected $table = 'orangs';
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
