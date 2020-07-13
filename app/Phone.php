<?php

namespace App;

use Illuminate\Support\Facades\Gate;
use App\Traits\PhoneTrait;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
	use PhoneTrait;

	protected $table = 'phones';
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
