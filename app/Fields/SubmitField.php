<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class SubmitField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Submit';
	public $class = 'btn';

	public function viewName()
	{
		return 'fields.button';
	}
}