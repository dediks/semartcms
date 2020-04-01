<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class FileField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'File';

	public function type()
	{
		return 'file';
	}

	public function viewName()
	{
		return 'fields.file';
	}
}