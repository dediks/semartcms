<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class EmailField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Email';

	public function type()
	{
		return 'email';
	}

	public function viewName()
	{
		return 'fields.email';
	}
}
