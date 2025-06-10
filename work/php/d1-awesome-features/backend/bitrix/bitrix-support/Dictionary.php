<?php

namespace App\Services\BitrixSupport;

use CTicketDictionary;

class Dictionary
{
	public const CATEGORY_TYPE_CODE = 'C';
	public const CRITICALITY_TYPE_CODE = 'K';
	public const STATUS_TYPE_CODE = 'S';
	public const EVALUATING_RESPONSES_TYPE_CODE = 'M';
	public const FREQUENTLY_ANSWERS_TYPE_CODE = 'F';
	public const SOURCE_TYPE_CODE = 'SR';
	public const COMPLEXITY_TYPE_CODE = 'D';

	public function getDictionary(array $filter = [], string $sort = 's_c_sort', string $order = 'asc'): array
	{
		$result = [];
		$data = CTicketDictionary::GetList($sort, $order, $filter);

		while ($item = $data->Fetch()) {
			$result[] = $item;
		}

		return $result;
	}

	public function getCategoryDictionary(array $filter = [], string $sort = 's_c_sort', string $order = 'asc'): array
	{
		$filter['TYPE'] = self::CATEGORY_TYPE_CODE;

		return $this->getDictionary($filter, $sort, $order);
	}

	public function getCriticalityDictionary(array $filter = [], string $sort = 's_c_sort', string $order = 'asc'): array
	{
		$filter['TYPE'] = self::CRITICALITY_TYPE_CODE;

		return $this->getDictionary($filter, $sort, $order);
	}

	public function getStatusDictionary(array $filter = [], string $sort = 's_c_sort', string $order = 'asc'): array
	{
		$filter['TYPE'] = self::STATUS_TYPE_CODE;

		return $this->getDictionary($filter, $sort, $order);
	}

	public function getEvaluatingResponsesDictionary(array $filter = [], string $sort = 's_c_sort', string $order = 'asc'): array
	{
		$filter['TYPE'] = self::EVALUATING_RESPONSES_TYPE_CODE;

		return $this->getDictionary($filter, $sort, $order);
	}

	public function getFrequentlyAnswersDictionary(array $filter = [], string $sort = 's_c_sort', string $order = 'asc'): array
	{
		$filter['TYPE'] = self::FREQUENTLY_ANSWERS_TYPE_CODE;

		return $this->getDictionary($filter, $sort, $order);
	}

	public function getSourceDictionary(array $filter = [], string $sort = 's_c_sort', string $order = 'asc'): array
	{
		$filter['TYPE'] = self::SOURCE_TYPE_CODE;

		return $this->getDictionary($filter, $sort, $order);
	}

	public function getComplexityDictionary(array $filter = [], string $sort = 's_c_sort', string $order = 'asc'): array
	{
		$filter['TYPE'] = self::COMPLEXITY_TYPE_CODE;

		return $this->getDictionary($filter, $sort, $order);
	}
}