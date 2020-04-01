<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class RichtextField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Richtext';

	public function type()
	{
		return 'textarea';
	}

	public function viewName()
	{
		return 'fields.input';
	}

	public function addClass()
	{
		return 'summernote-simple';
	}

	public function css()
	{
		return [
		    'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css'
		];
	}

	public function js()
	{
		return [
    		'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.min.js'
		];
	}
}