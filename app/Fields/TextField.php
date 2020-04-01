<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class TextField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Text';

	public function type()
	{
		return 'text';
	}

	public function viewName()
	{
		return 'fields.input';
	}
}