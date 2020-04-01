<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class CodeField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Code';

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
		return 'codeeditor';
	}

	public function css()
	{
		return [
			'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.46.0/theme/seti.min.css',
			'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.46.0/codemirror.min.css'
		];
	}

	public function js()
	{
		return [
			'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.46.0/codemirror.min.js'
		];
	}
}