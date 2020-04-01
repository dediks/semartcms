<?php

namespace App\Facades;

use Fields\Field;

class FieldHelperFacade 
{
	public function field($type=null)
	{
		return new Field($type);
	}

	public function list()
	{
		return $this->field()->unregister();
	}

	public function getDisplayName($type)
	{
		$type = $this->get($type);

		return $this->field($type)->init()->displayName;
	}

	public function get($type) {
		$type = explode("|", $type);
		return $type[0];
	}

	public function getOptions($type) {
		$type = explode("|", $type);
		if(count($type) > 1) {
			return $type[1];
		}
	}

	public function getRequired($type) {
		$type = explode("|", $type);
		if(count($type) > 1) {
			return $type[2];
		}
	}

	public function options($options) {
		$to_options = $this->getOptions($options);
		$to_array = explode(",", $to_options);
		$arr = [];
		foreach($to_array as $item) {
			$arr[str_replace(" ", "", $item)] = trim($item);
		}
		return $arr;
	}
}
