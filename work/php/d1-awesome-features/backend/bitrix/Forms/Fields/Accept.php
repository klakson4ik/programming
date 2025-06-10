<?php

namespace App\Services\Forms\Fields;

class Accept extends Checkbox
{
	public function __construct(string $name = 'POLICY', array $params = [], string $value = 'Y')
	{
		if (!$params['value']) {
			$params['value'] = $value;
		}

		if (!$params['mod']) {
			$params['mod'] = 'text-up';
		}

		parent::__construct($name, $this->getLabel(), $params);

		$this->checked = true;
	}

	public function getLabel(): string
	{
		return '<span class="c-font-tiny c-color-grey">Продолжая, Bы соглашаетесь с <a class="c-link" href="https://www.tarkett.ru/ru_RU/node/terms-of-use-961" target="_blank">условиями использования Tarkett</a>, <a class="c-link" href="https://www.tarkett.ru/ru_RU/node/privacy-legal-statement-962" target="_blank">Уведомлением о конфиденциальности</a> и <a class="c-link" href="https://www.tarkett.ru/ru_RU/node/personal-information-1190" target="_blank">пользовательским соглашением</a>.</span>';
	}
}