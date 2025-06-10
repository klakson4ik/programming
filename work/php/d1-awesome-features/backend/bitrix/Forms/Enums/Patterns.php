<?php

namespace App\Services\Forms\Enums;

enum Patterns: string
{
	case EMAIL = '^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$';
	case PHONE = '^\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}$';
	case INN = '^(?:\d{10}|\d{12})$';
}
