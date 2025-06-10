<?php

namespace App\Services\Forms\Storages;

use App\Services\BitrixSupport\BitrixSupportService;
use App\Services\BitrixSupport\Ticket\TicketFields;
use App\Services\Forms\Exceptions\FormException;
use App\Services\Forms\Interfaces\StorageInterface;
use COption;

final class BitrixSupportStorage implements StorageInterface
{
	private ?int $tickedId;

	public function __construct(&$tickedId)
	{
		$this->tickedId = &$tickedId;
	}

	/**
	 * @throws FormException
	 */
	public function store(array $fields = []): void
	{
		$service = BitrixSupportService::instance();

		$ticked = (new TicketFields())
			->setTitle('Обращение с формы обратной связи от ' . date('d.m.Y H:i:s'))
			->setEmail($fields['email'])
			->setPhone($fields['phone'])
			->setName($fields['name'])
			->setMessage($fields['message'])
			->setCategoryId((int)$fields['category_id'])
			->setMangerId($this->findMangerID())
			->setFiles($fields['files']);

		$result = $service->ticket->create($ticked);

		$this->tickedId = (int)$result['id'];

		if (!$this->tickedId) {
			throw new FormException('Ошибка при создании обращения');
		}
	}

	protected function findMangerID(): int
	{
		return (int)COption::GetOptionString("support", "DEFAULT_RESPONSIBLE_ID", '1');
	}
}