<?php

namespace App\Support\Factories\Abstract;

use CIBlockElement;

abstract class IBlockFactory extends AbstractBitrixFactory
{
	/**
	 * ID инфоблока
	 *
	 * @var string|int
	 */
	protected static string|int $IBlockId;

	/**
	 * Класс для работы с элементами инфоблока
	 *
	 * @var CIBlockElement
	 */
	protected CIBlockElement $bitrixElement;

	public function __construct()
	{
		parent::__construct();
		$this->bitrixElement = new CIBlockElement();
	}

	public function create(): array
	{
		$result = [];

		if ($this->drop) {
			$this->deleteElements();
		}

		for ($i = 0; $i < $this->count; ++$i) {
			$elementID = $this->bitrixElement->Add(array_merge(
				$this->baseFields(),
				$this->fields()
			));

			if ($elementID) {
				$result['ids'][] = $elementID;
			} else {
				$result['errors'][] = $this->bitrixElement->LAST_ERROR;
			}
		}

		return $result;
	}

	protected function baseFields(): array
	{
		return [
			'IBLOCK_ID' => static::$IBlockId,
			'ACTIVE' => 'Y',
			'MODIFIED_BY' => 1
		];
	}

	protected function deleteElements(): void
	{
		$elementsData = $this->bitrixElement::GetList([], [
			'IBLOCK_ID' => static::$IBlockId
		], false, false, ['ID']);

		while ($element = $elementsData->Fetch()) {
			$this->bitrixElement::Delete($element['ID']);
		}
	}
}
