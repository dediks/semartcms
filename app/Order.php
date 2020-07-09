<?php

namespace App;

use Laravel\Scout\Searchable;
use App\Traits\OrderTrait;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use OrderTrait;

	protected $table = 'orders';
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
