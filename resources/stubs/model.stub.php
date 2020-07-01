<?php

namespace App;
use App\Traits\{Name}Trait;

use Illuminate\Database\Eloquent\Model;

class {Name} extends Model
{
	use {Name}Trait;

	protected $table = '{plural}';
	protected $guarded  = [];
}
