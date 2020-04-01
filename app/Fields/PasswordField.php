<?php

namespace Fields;

use Fields\Interfaces\FieldInterface;
use Fields\Abstracts\FieldAbstract;

class PasswordField extends FieldAbstract implements FieldInterface
{
	public $displayName = 'Password';

	public function type()
	{
		return 'password';
	}

	public function viewName()
	{
		return 'fields.password';
	}
}