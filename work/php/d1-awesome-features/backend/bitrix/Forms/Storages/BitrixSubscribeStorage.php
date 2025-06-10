<?php

namespace App\Services\Forms\Storages;

use App\Services\BitrixSubscribe\Subscriber;
use App\Services\BitrixSubscribe\SubscriberException;
use App\Services\Forms\Exceptions\FormException;
use App\Services\Forms\Interfaces\StorageInterface;
use Bitrix\Main\Loader;

class BitrixSubscribeStorage implements StorageInterface
{
	private bool $needConfirm;

	public function __construct(bool $needConfirm = true)
	{
		Loader::includeModule('subscribe');

		$this->needConfirm = $needConfirm;
	}

	public function store(array $fields = []): void
	{
		try {
			(new Subscriber())->addByEmail($fields['email'], $this->needConfirm);
		} catch (SubscriberException $e) {
			throw new FormException('Ошибка при подписке', errors: [
				'subscribe' => $e->getMessage()
			]);
		}
	}
}