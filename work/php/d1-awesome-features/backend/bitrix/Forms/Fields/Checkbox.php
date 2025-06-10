<?php

namespace App\Services\Forms\Fields;

use TAO;

class Checkbox extends AbstractField
{
	protected bool $checked = false;
	protected bool $disabled = false;

	public function __construct(string $name, string $label, array $params = [])
	{
		parent::__construct($name, $label, $params);

		if ($params['checked']) {
			$this->checked = (bool)$params['checked'];
		}

		if ($params['disabled']) {
			$this->disabled = (bool)$params['disabled'];
		}
	}

	public function render(): string
	{
		return TAO::frontend()->renderBlock('fields/checkbox', [
			'name' => $this->name,
			'value' => (int)$this->value,
			'required' => $this->required,
			'id' => $this->id,
			'label' => $this->label,
			'attrs' => $this->attrs,
			'checked' => $this->checked,
			'disabled' => $this->disabled,
			'mod' => $this->mod,
		]);
	}
}