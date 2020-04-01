<?php

namespace Fields\Abstracts;

abstract class FieldAbstract
{

	public $displayName;

	public $name = null;

	public $label = null;

	public $text = null;

	public $attrs = [];

	public $defaultValue = null;

	public $options = [];

	public $class = 'form-control';

	public $type = 'text';

	public $typeAlias = null;

	public $horizontal = true;

	public $help = null;

	public $baseView = 'fields.field';

	abstract public function viewName();

	public function __construct($data=false)
	{
		if(isset($data) && is_array($data))
		{
			if(isset($data['class'])) $this->class .= ' ' . $data['class'];
			if(isset($data['horizontal'])) $this->horizontal = $data['horizontal'];

			$this->type = $data['type'];
			$this->name = $data['name'] ?? null;
			$this->label = $data['label'] ?? null;
			$this->text = $data['text'] ?? null;
			$this->help = $data['help'] ?? null;
			$this->defaultValue = $data['value'] ?? null;
			$this->options = $data['options'] ?? [];
			$this->attrs = $data['attrs'] ?? [];
		}
	}

	public function getType()
	{
		if(method_exists($this, 'type'))
		{
			return $this->type();
		}

		return $this->type;
	}

	public function getTypeAlias()
	{
		if(method_exists($this, 'typeAlias'))
		{
			return $this->typeAlias();
		}

		return $this->typeAlias;
	}

	public function getAdditionalData()
	{
		if(method_exists($this, 'additionalData'))
		{
			return $this->additionalData();
		}

		return [];
	}

	public function getData()
	{
		return [
			'options' => $this->options,
			'horizontal' => $this->horizontal,
			'type' => $this->getType(),
			'type_alias' => $this->getTypeAlias(),
			'name' => $this->name,
			'label' => $this->label,
			'text' => $this->text,
			'help' => $this->help,
			'attrs' => $this->attrs + ['class' => $this->getClass(), 'id' => 'field-' . $this->name],
			'value' => $this->defaultValue,
			'css' => $this->getCss(),
			'js' => $this->getJs(),
			'script' => $this->getScript()
		] + $this->getAdditionalData();
	}

	public function getClass()
	{
		$class = $this->class;

		if(method_exists($this, 'setClass'))
		{
			return $this->classClass();
		}

		if(method_exists($this, 'addClass'))
		{
			return $class . ' ' . $this->addClass();
		}

		return $class;
	}

	public function getCss()
	{
		if(method_exists($this, 'css'))
		{
			return $this->css();
		}

		return [];
	}

	public function getJs()
	{
		if(method_exists($this, 'js'))
		{
			return $this->js();
		}

		return [];
	}

	public function getScript()
	{
		if(method_exists($this, 'script'))
		{
			return $this->script();
		}

		return null;
	}

	public function getBaseView()
	{
		if(method_exists($this, 'baseView'))
		{
			return $this->baseView();
		}

		return $this->baseView;
	}

	public function getView()
	{
		if(method_exists($this, 'viewName'))
		{
			return $this->viewName();
		}
	}

	public function render()
	{
		$data = $this->getData() + ['view' => $this->getView()];

		return view($this->getBaseView())->with($data);
	}
}