<?php

namespace App\Support\Factories\Abstract;

use CModule;
use Faker\Factory;
use Faker\Generator;

abstract class AbstractBitrixFactory
{
	/**
	 * Кол-во создаваемых элементов
	 *
	 * @var int
	 */
	protected int $count = 1;

	/**
	 * Удалять ли старые элементы, при новой генерации
	 *
	 * @var bool
	 */
	protected bool $drop = false;

	/**
	 * Сущность генератора
	 *
	 * @var Generator
	 */
	public Generator $faker;

	/**
	 * Дополнительные поля
	 *
	 * @var array
	 */
	protected array $additional;

	public function __construct()
	{
		CModule::IncludeModule('iblock');
		CModule::IncludeModule("highloadblock");

		$this->faker = Factory::create();
	}

	/**
	 * Создает сущность фабрики
	 *
	 * @return static
	 */
	public static function new(): static
	{
		return (new static());
	}

	/**
	 * Устанавливает кол-во создаваемых сущностей
	 *
	 * @param $count
	 * @return $this
	 */
	public function count($count): static
	{
		$this->count = $count;

		return $this;
	}

	/**
	 * Устанавливает удаление предыдущих генераций
	 *
	 * @return $this
	 */
	public function withDrop(): static
	{
		$this->drop = true;

		return $this;
	}

	/**
	 * Устанавливает дополнительные свойства для генерации сущности
	 *
	 * @param array $data
	 * @return $this
	 */
	public function additional(array $data): static
	{
		$this->additional = $data;

		return $this;
	}

	/**
	 * Создает элементы
	 *
	 * @return array
	 */
	abstract public function create(): array;

	/**
	 * Базовые поля, необходимые для всех элементов
	 *
	 * @return array
	 */
	abstract protected function baseFields(): array;

	/**
	 * Метод, отвечающий за удаления элементов сущности
	 *
	 * @return void
	 */
	abstract protected function deleteElements(): void;

	/**
	 * Массив полей сущности
	 *
	 * @return array
	 */
	abstract public function fields(): array;
}
