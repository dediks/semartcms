<?php

namespace Fields;

class Field
{
	public $fields;
	protected $type;

	public function __construct($type = false)
	{

		$this->register();

		if ($type)
			$this->type = $type;
	}

	public function register()
	{
		$this->fields = [
			'text' => TextField::class,
			'button' => ButtonField::class,
			'submit' => SubmitField::class,
			'password' => PasswordField::class,
			'number' => NumberField::class,
			'textarea' => TextareaField::class,
			'richtext' => RichtextField::class,
			'code' => CodeField::class,
			'checkbox' => CheckboxField::class,
			'radio' => RadioField::class,
			'select' => SelectField::class,
			'file' => FileField::class,
			'image' => ImageField::class,
			'media_image' => MediaImageField::class,
			'media_file' => MediaFileField::class,
			'datepicker' => DatepickerField::class,
			'timepicker' => TimepickerField::class,
			'currency' => CurrencyField::class,
			'email' => EmailField::class,
			'date' => DatePickerField::class,
		];
	}

	public function init()
	{
		return new $this->fields[$this->type];
	}

	public function unregister()
	{
		$this->fields = array_except($this->fields, ['button', 'submit']);

		return $this->fields;
	}

	public function run($data)
	{
		$field = optional($this->fields)[$this->type];

		if (!class_exists($field)) {
			throw new \Exception("The '$this->type' type isn't supported.", 1);
		}

		$field = new $field($data + ['type' => $this->type]);

		return $field->render();
	}
}
