<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class DatepickerField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Datepicker';

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
		return 'datepicker';
	}

	public function css()
	{
		return [
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css'
		];
	}

	public function js()
	{
		return [
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js'
		];
	}
}