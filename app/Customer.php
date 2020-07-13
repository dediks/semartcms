<?php

namespace App;

use Illuminate\Support\Facades\Gate;
use App\Traits\CustomerTrait;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	use CustomerTrait;

	protected $table = 'customers';
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
