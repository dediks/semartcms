<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class SelectField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Select';

	public function type()
	{
		return 'select';
	}

	public function viewName()
	{
		return 'fields.select';
	}
}