<?php

namespace App\Support\Factories\Abstract;

use CIBlockSection;

abstract class IBlockSectionFactory extends AbstractBitrixFactory
{
	/**
	 * ID инфоблока
	 *
	 * @var string|int
	 */
	protected static string|int $IBlockId;

	/**
	 * Класс для работы с секциями(разделами) инфоблока
	 *
	 * @var CIBlockSection
	 */
	protected CIBlockSection $bitrixSection;

	public function __construct()
	{
		parent::__construct();
		$this->bitrixSection = new CIBlockSection();
	}

	public function create(): array
	{
		$result = [];

		if ($this->drop) {
			$this->deleteElements();
		}

		for ($i = 0; $i < $this->count; ++$i) {
			$elementID = $this->bitrixSection->Add(array_merge(
				$this->baseFields(),
				$this->fields()
			));

			if ($elementID) {
				$result['ids'][] = $elementID;
			} else {
				$result['errors'][] = $this->bitrixSection->LAST_ERROR;
			}
		}

		return $result;
	}

	protected function baseFields(): array
	{
		return [
			'IBLOCK_ID' => static::$IBlockId,
			'ACTIVE' => 'Y',
		];
	}

	protected function deleteElements(): void
	{
		$elementsData = CIBlockSection::GetList([], [
			'IBLOCK_ID' => static::$IBlockId
		], false, ['ID', 'IBLOCK_ID'], false);

		while ($element = $elementsData->Fetch()) {
			$this->bitrixSection::Delete($element['ID'], false);
		}
	}
}
