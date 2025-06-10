<?php

namespace App\Services\BitrixSubscribe;

use Exception;

class SubscriberException extends Exception
{
	public function __construct(string $message) {
		parent::__construct($message);
	}
}