<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class ButtonField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Button';
	public $class = 'btn';

	public function viewName()
	{
		return 'fields.button';
	}
}