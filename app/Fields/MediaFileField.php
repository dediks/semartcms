<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class MediaFileField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Media File';
	public $typeAlias = 'media_file';

	public function type()
	{
		return 'text';
	}

	public function additionalData()
	{
		return [
			'directory' => 'files'
		];
	}

	public function viewName()
	{
		return 'fields.media';
	}
}