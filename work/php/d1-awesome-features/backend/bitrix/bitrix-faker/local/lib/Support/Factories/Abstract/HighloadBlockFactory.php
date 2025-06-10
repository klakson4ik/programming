<?php

namespace App\Support\Factories\Abstract;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\SystemException;
use Exception;

abstract class HighloadBlockFactory extends AbstractBitrixFactory
{
	/**
	 * ID HightLoad блока
	 *
	 * @var string|int
	 */
	protected static string|int $HLBlockID;

	/**
	 * Класс для работы с HightLoad блоком
	 *
	 * @var string|DataManager
	 */
	protected string|DataManager $bitrixHLBlockClass;

	/**
	 * @throws ObjectPropertyException
	 * @throws SystemException
	 * @throws ArgumentException
	 */
	public function __construct()
	{
		parent::__construct();

		$hlblock = HL\HighloadBlockTable::getById(static::$HLBlockID)->fetch();
		$entity = HL\HighloadBlockTable::compileEntity($hlblock);
		$this->bitrixHLBlockClass = $entity->getDataClass();
	}

	/**
	 * @throws Exception
	 */
	public function create(): array
	{
		$result = [];

		if ($this->drop) {
			$this->deleteElements();
		}

		for ($i = 0; $i < $this->count; ++$i) {
			$elem = $this->bitrixHLBlockClass::add($this->fields());
			$result[] = $elem->getData()['UF_XML_ID'];
		}


		return $result;
	}

	protected function baseFields(): array
	{
		return [];
	}

	/**
	 * @throws ObjectPropertyException
	 * @throws SystemException
	 * @throws ArgumentException
	 * @throws Exception
	 */
	protected function deleteElements(): void
	{
		$elementsData = $this->bitrixHLBlockClass::getList([
			'select' => ['ID'],
			'order' => ['ID' => 'ASC']
		]);

		while ($element = $elementsData->Fetch()) {
			$this->bitrixHLBlockClass::delete($element['ID']);
		}
	}
}
