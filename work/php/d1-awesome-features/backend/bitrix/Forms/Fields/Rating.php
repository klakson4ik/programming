<?php

namespace App\Services\Forms\Fields;

use TAO;

class Rating extends AbstractField
{
	private int $max = 5;

	public function __construct(string $name, string $label, array $params = [])
	{
		parent::__construct($name, $label, $params);

		if ($params['max']) {
			$this->max = (int)$params['max'];
		}
	}

	public function render(): string
	{
		return TAO::frontend()->renderBlock('fields/rating-field', [
			'name' => $this->name,
			'max' => $this->max,
			'value' => (int)$this->value,
			'required' => $this->required,
			'id' => $this->id,
			'label' => $this->label,
			'attrs' => $this->attrs,
			'mod' => $this->mod,
		]);
	}
}