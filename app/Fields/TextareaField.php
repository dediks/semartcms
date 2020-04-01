<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class TextareaField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Textarea';

	public function type()
	{
		return 'textarea';
	}

	public function viewName()
	{
		return 'fields.input';
	}
}