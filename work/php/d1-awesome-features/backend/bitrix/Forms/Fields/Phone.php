<?php

namespace App\Services\Forms\Fields;

use App\Services\Forms\Enums\Patterns;

class Phone extends Input
{
	public function __construct(string $name, string $label, array $params = [])
	{
		parent::__construct($name, $label, $params);

		$this->pattern = $params['no_pattern'] ? '' : Patterns::PHONE->value;
		$this->autocomplete = $params['autocomplete'] === false ? 'off' : 'on';
		$this->type = 'tel';
		$this->mask = 'phone';
	}

	/**
	 * Форматирует телефон по маске ввида - ^\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}$
	 *
	 * @param string $phone
	 * @return string
	 */
	public static function preparePhone(string $phone): string
	{
		$cleaned = preg_replace('/\D+/', '', $phone);

		if (str_starts_with($cleaned, '8')) {
			$cleaned = '7' . substr($cleaned, 1);
		}

		// Проверка, что номер начинается с +7 и имеет нужное количество цифр (11 цифр для России)
		if (strlen($cleaned) === 11 && str_starts_with($cleaned, '7')) {
			return preg_replace('/(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/', '+$1 ($2) $3-$4-$5', $cleaned);
		}

		// Телефон не подходит по формату
		return $phone;
	}
}