<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class NumberField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Number';

	public function type()
	{
		return 'number';
	}

	public function viewName()
	{
		return 'fields.input';
	}
}