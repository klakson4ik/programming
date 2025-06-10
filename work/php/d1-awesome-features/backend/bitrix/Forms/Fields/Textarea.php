<?php

namespace App\Services\Forms\Fields;

use TAO;

class Textarea extends AbstractField
{
	public function render(): string
	{
		return TAO::frontend()->renderBlock('fields/textarea', [
			'name' => $this->name,
			'id' => $this->id,
			'required' => $this->required,
			'placeholder' => $this->label,
			'mod' => $this->mod,
			'value' => $this->value
		]);
	}
}