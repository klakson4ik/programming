<?php

namespace App\Services\Forms\Interfaces;

interface ValidatorInterface
{
	public function validate(array $values, array $fields): static;

	public function getFields(): array;
}