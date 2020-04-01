<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class ImageField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Image';

	public function type()
	{
		return 'file';
	}

	public function typeAlias()
	{
		return 'image';
	}

	public function viewName()
	{
		return 'fields.file';
	}
}