<?php

namespace App\Services\Forms\Fields;

use App\Services\Forms\Enums\Patterns;

class Email extends Input
{
	public function __construct(string $name, string $label, array $params = [])
	{
		parent::__construct($name, $label, $params);

		$this->pattern = $params['no_pattern'] ? '' : Patterns::EMAIL->value;
		$this->type = 'email';
		$this->autocomplete = $params['autocomplete'] === false ? 'off' : 'on';
	}
}