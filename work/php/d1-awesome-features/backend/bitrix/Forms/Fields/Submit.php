<?php

namespace App\Services\Forms\Fields;

use TAO;

class Submit extends AbstractField
{
	public function __construct(string $label = 'Отправить')
	{
		parent::__construct('', $label, [
			'required' => false,
			'store' => false
		]);
	}

	public function render(): string
	{
		return TAO::frontend()->renderBlock('common/button', [
			'label' => $this->label,
			'mod' => 'full',
			'type' => 'submit',
			'preloader' => true
		]);
	}
}