<?php

namespace App;

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
}
