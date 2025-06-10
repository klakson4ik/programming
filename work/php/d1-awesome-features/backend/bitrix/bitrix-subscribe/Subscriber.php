<?php

namespace App\Services\BitrixSubscribe;

use Bitrix\Main\Loader;
use CSubscription;

class Subscriber
{
	public const RUB_MAIN_ID = 1; //id общей рассылки с сайта
	private CSubscription $service;

	public function __construct()
	{
		Loader::includeModule('subscribe');

		$this->service = new CSubscription();
	}

	public function getById(int $id): false|array
	{
		$subscribe = $this->service::GetByID($id);

		return $subscribe ? $subscribe->Fetch() : false;
	}

	public function unsubscribe(int $id): false|array
	{
		return $this->service::Delete($id)->Fetch();
	}

	/**
	 * @throws SubscriberException
	 */
	public function addByEmail(string $email, bool $needConfirm = true, array $rubIds = [self::RUB_MAIN_ID]): int
	{
		$subscribeID = $this->service->Add([
			'FORMAT' => 'html',
			'RUB_ID' => $rubIds,
			'EMAIL' => $email,
			'SEND_CONFIRM' => $needConfirm ? 'Y' : 'N',
			'CONFIRMED' => !$needConfirm ? 'Y' : 'N',
			'ACTIVE' => 'Y',
		]);

		if (!$subscribeID) {
			throw new SubscriberException($this->service->LAST_ERROR);
		}

		return $subscribeID;
	}

	/**
	 * @throws SubscriberException
	 */
	public function confirm(int $id, string $code): bool
	{
		$res = $this->service->Update($id, [
			'CONFIRM_CODE' => $code
		]);

		if (!$res) {
			throw new SubscriberException($this->service->LAST_ERROR);
		}

		return $res;
	}
}