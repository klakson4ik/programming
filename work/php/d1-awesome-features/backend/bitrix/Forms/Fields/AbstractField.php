<?php

namespace App\Services\Forms\Fields;

abstract class AbstractField
{
	public mixed $validate;
	public mixed $value;
	public bool $required;
	public bool $store;
	public string $name;
	public string $label;
	public string $pattern;
	public string $validate_error_message;
	public string $id;
	public string $form_id;
	public array $attrs;
	public array|string $form_mod;
	public array|string $mod;

	public function __construct(string $name, string $label, array $params = [])
	{
		$this->name = $name;
		$this->label = $label;
		$this->form_id = $params['form_id'] ?? '';
		$this->id = $params['id'] ?? ($this->form_id ? $this->form_id.'-field-'.$this->name : 'form-field-'.$this->name);
		$this->value = $params['value'] ?? '';
		$this->store = $params['store'] ?? true;
		$this->required = $params['required'] ?? false;
		$this->validate = $params['validate'] ?? '';
		$this->pattern = $params['pattern'] ?? '';
		$this->validate_error_message = $params['validate_error_message'] ?? '';
		$this->attrs = $params['attrs'] ?? [];
		$this->form_mod = $params['form_mod'] ?? '';
		$this->mod = $params['mod'] ?? '';
	}

	abstract public function render(): string;
}