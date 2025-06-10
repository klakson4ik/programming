<?php

namespace App\Services\Forms\Storages;

use App\Services\Forms\Exceptions\FormException;
use App\Services\Forms\Interfaces\StorageInterface;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use CFormResult;

class WebFormStorage implements StorageInterface
{
	private int $formId;

	/**
	 * @throws LoaderException
	 */
	public function __construct(int $formId)
	{
		Loader::IncludeModule('form');

		$this->formId = $formId;
	}

	/**
	 * @throws FormException
	 */
	public function store(array $fields = [], string $checkRights = 'N'): void
	{
		$id = CFormResult::Add($this->formId, $fields, $checkRights);

		if (!$id) {
			global $strError;

			throw new FormException(
				'Ошибка при сохранении формы',
				errors: ['server' => $strError]
			);
		}
	}
}