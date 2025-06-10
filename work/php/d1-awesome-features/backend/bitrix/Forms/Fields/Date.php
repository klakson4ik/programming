<?php

namespace App\Services\Forms\Fields;

class Date extends AbstractField
{
	public function render(): string
	{
		return \TAO::frontend()->renderBlock('fields/date', [
			'name' => $this->name,
			'value' => $this->value,
			'required' => $this->required,
			'id' => $this->id,
			'placeholder' => $this->label,
			'pattern' => $this->pattern,
			'attrs' => $this->attrs,
			'mod' => $this->mod,
		]);
	}
}