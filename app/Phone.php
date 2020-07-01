<?php

namespace App;

use App\Traits\PhoneTrait;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
	use PhoneTrait;

	protected $table = 'phones';
	protected $guarded  = [];
}
