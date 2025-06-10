<?php

namespace App\Services\Forms\Exceptions;

use Exception;
use Throwable;

class FormException extends Exception
{
	public function __construct(
		string $message = '',
		private readonly array $errors = []
	) {
		parent::__construct($message, 0, null);
	}

	public function getErrors(): array
	{
		return $this->errors;
	}
}
