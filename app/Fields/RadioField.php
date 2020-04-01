<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class RadioField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Radio';

	public function type()
	{
		return 'radio';
	}

	public function viewName()
	{
		return 'fields.choice';
	}
}