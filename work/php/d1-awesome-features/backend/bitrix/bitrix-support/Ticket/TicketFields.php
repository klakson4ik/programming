<?php

namespace App\Services\BitrixSupport\Ticket;

use COption;

final class TicketFields
{
	public string $title;
	public string $message;
	public string $email;
	public string $name;
	public string $phone;
	public int $manger_id;
	public int $category_id;
	public array $files = [];
	public int $status_id = 7; // Принято к рассмотрению
	public int $criticality_id = 5; // Умеренная
	public string $source_type = 'hotline'; // форма горячей линии takett
	public string $sla_id; // Уровни техподдержки (SLA)

	public function __construct()
	{
		$this->sla_id = COption::GetOptionString("support", "SUPPORT_DEFAULT_SLA_ID", '1');
	}

	public function toArray(): array
	{
		return [
			'TITLE' => $this->title,
			'MESSAGE' => $this->message,
			'SOURCE_SID' => $this->source_type,
			'OWNER_SID' => $this->email,
			'CATEGORY_ID' => $this->category_id,
			'CRITICALITY_ID' => $this->criticality_id,
			'STATUS_ID' => $this->status_id,
			'SLA_ID' => $this->sla_id,
			'RESPONSIBLE_USER_ID' => $this->manger_id,
			'FILES' => $this->files,
			'UF_PHONE' => $this->phone,
			'UF_NAME' => $this->name,
		];
	}

	public function getSlaId(): string
	{
		return $this->sla_id;
	}

	public function setSlaId(string $sla_id): self
	{
		$this->sla_id = $sla_id;
		return $this;
	}

	public function setTitle(string $title): self
	{
		$this->title = $title;
		return $this;
	}

	public function setName(string $name): self
	{
		$this->name = $name;
		return $this;
	}

	public function setPhone(string $phone): self
	{
		$this->phone = $phone;
		return $this;
	}

	public function setMessage(string $message): self
	{
		$this->message = $message;
		return $this;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;
		return $this;
	}

	public function setMangerId(int $manger_id): self
	{
		$this->manger_id = $manger_id;
		return $this;
	}

	public function setCategoryId(int $category_id): self
	{
		$this->category_id = $category_id;
		return $this;
	}

	public function setFiles(array $files): self
	{
		$this->files = $files;
		return $this;
	}

	public function setStatusId(int $status_id): self
	{
		$this->status_id = $status_id;
		return $this;
	}

	public function setCriticalityId(int $criticality_id): self
	{
		$this->criticality_id = $criticality_id;
		return $this;
	}

	public function setSourceType(string $sourceType): self
	{
		$this->source_type = $sourceType;
		return $this;
	}

	public static function fromArray(array $fields): self
	{
		$instance = new self();

		foreach ($fields as $key => $value) {
			if (property_exists($instance, $key)) {
				$instance->{$key} = $value;
			}
		}

		return $instance;
	}
}