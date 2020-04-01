<?php

namespace App\Traits;

trait TwoTable 
{
	public function getTwoTableAttribute()
	{
		return $this->columns;
	}
}