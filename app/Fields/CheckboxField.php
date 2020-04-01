<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class CheckboxField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Checkbox';

	public function type()
	{
		return 'checkbox';
	}

	public function viewName()
	{
		return 'fields.choice';
	}
}