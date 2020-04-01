<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class TimepickerField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Timepicker';

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
		return 'timepicker';
	}

	public function css()
	{
		return [
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css'
		];
	}

	public function js()
	{
		return [
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js'
		];
	}
}