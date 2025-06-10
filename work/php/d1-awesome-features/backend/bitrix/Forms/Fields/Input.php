<?php

namespace App\Services\Forms\Fields;

use TAO;

class Input extends AbstractField
{
	public string $type;
	public string $autocomplete;
	public array $attrs;
	public string $mask = '';
	public string|array $label_mod;

	public function __construct(string $name, string $label, array $params = [])
	{
		parent::__construct($name, $label, $params);

		$this->pattern = $params['pattern'] ?? '';
		$this->autocomplete = $params['autocomplete'] === false ? 'off' : 'on';
		$this->type = $params['type'] ?? 'text';
		$this->label_mod = $params['label_mod'] ?? '';
	}

	public function render(): string
	{
		return TAO::frontend()->renderBlock('fields/input', [
			'name' => $this->name,
			'value' => $this->value,
			'required' => $this->required,
			'type' => $this->type,
			'id' => $this->id,
			'placeholder' => $this->label,
			'pattern' => $this->pattern,
			'autocomplete' => $this->autocomplete,
			'attrs' => $this->attrs,
			'mask' => $this->mask,
			'mod' => $this->mod,
			'label_mod' => $this->label_mod,
		]);
	}
}