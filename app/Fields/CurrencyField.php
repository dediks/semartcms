<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class CurrencyField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Currency';

	public function type()
	{
		return 'text';
	}

	public function viewName()
	{
		return 'fields.input';
	}

	public function addClass()
	{
		return 'currency';
	}

	public function js()
	{
		return [
			'https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.4.10/cleave.min.js'
		];
	}
}