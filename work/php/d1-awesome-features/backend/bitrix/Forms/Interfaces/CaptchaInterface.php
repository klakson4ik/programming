<?php

namespace App\Services\Forms\Interfaces;

interface CaptchaInterface
{
	public function verify(?string $token);
}