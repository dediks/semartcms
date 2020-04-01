<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class MediaImageField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Media Image';
	public $typeAlias = 'media_image';

	public function type()
	{
		return 'text';
	}

	public function additionalData()
	{
		return [
			'directory' => 'images'
		];
	}

	public function viewName()
	{
		return 'fields.media';
	}
}