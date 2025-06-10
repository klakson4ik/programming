<?php

namespace App\Services;
use Exception;

class HHService
{
	/**
	 * URL API HeadHunter'а
	 * 
	 * @var string
	 */
	private const API_URL = 'https://api.hh.ru/';

	/**
	 * ID работодателя
	 * 
	 * @var int|null
	 */
	private ?int $employerId;

	/**
	 * E-mail для заголовка User-Agent
	 * 
	 * @var string|int
	 */
	private ?string $email;

	/**
	 * Название продукта для заголовка User-Agent
	 * 
	 * @var string|null
	 */
	private ?string $productName;

	/**
	 * Версия продукта для заголовка User-Agent
	 * 
	 * @var float|string|null
	 */
	private ?float $productVersion;
	
	function __construct(
		int $employerId = null,
		string $email = null,
		string $productName = null,
		float|string $productVersion = null
	)
	{
		$this->employerId = $employerId;
		$this->email = $email;
		$this->productName = $productName;
		$this->productVersion = $productVersion;
	}

	public function __get(string $key): string|int|float|null
	{
		return $this->{$key};
	}

	public function __set(string $key, $value)
	{
		try {
			$this->{$key} = $value;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * Функция возвращает список вакансий работодателя по указанным параметрам
	 * 
	 * @param int $areaId ID региона В котором производится поиск
	 * @param int $perPage Количество вакансий на страницу
	 * @param int $page Номер страницы с вакансиями, отсчёт идёт от нуля
	 * @param bool $allParams Флаг отвечающий за вывод дополнительных параметров (количество страниц, число записей и пр.)
	 * @return array|bool|object Список вакансий и false в случае некорректного запроса или при неверном наборе параметров
	 */
	public function getVacancies(int $areaId = null, int $perPage = null, int $page = null, bool $allParams = false): array|bool
	{
		$params = [];
		$url = self::API_URL.'vacancies/';

 		if($this->employerId !== null) {
			$params['employer_id'] = $this->employerId;
		} else {
			return false;
		}
		if($perPage !== null) {
			$params['per_page'] = $perPage;
		}
		if($page !== null) {
			$params['page'] = $page;
		}
		if($areaId !== null) {
			$params['area'] = $areaId;
		}

		if(count($params) > 0) {
			$url .= '?';
			$last = array_key_last($params);
			foreach($params as $param => $value) {
				$url .= $param.'='.$value;
				if($param !== $last) {
					$url .= '&';
				}
			}
		}
		$result = $this->sendQuery($url);

		if($allParams === true) {
			return $result;
		}
		return $result['items'] ?? false;
	}

	/**
	 * Функция возвращает информацию по конкретной вакансии
	 * 
	 * @param int $vacancyId ID вакансии
	 * @return array|bool Массив с параметрами конкретной вакансии и false в случае отсутствия vacancyId
	 */
	public function getVacancy(int $vacancyId = null): array|false
	{
		if($vacancyId === null) {
			return false;
		}
		$url = self::API_URL.'vacancies/'.$vacancyId;
		return $this->sendQuery($url);
	}

	/**
	 * Функция возвращает список всех стран с их area_id
	 * 
	 * @return array Список стран
	 */
	public function getCountries(int|string $identifier = null): array
	{
		$url = self::API_URL.'areas/countries/';
		$countries = $this->sendQuery($url);
		if($identifier !== null) {
			if(gettype($identifier) === 'integer') {
				$countries = array_filter($countries, function($val) use($identifier) {
					return $val['id'] == $identifier;
				});
			} else {
				$countries = array_filter($countries, function($val) use($identifier) {
					return strpos(mb_strtolower($val['name']), mb_strtolower($identifier)) !== false;
				});
			}
		}
		return $countries; 
	}

	/**
	 * Функция возвращает список всех стран и их регионов, городов и населенных пунктов
	 * 
	 * @param int $areaId ID региона, страны или населенного пункта. Если указан, то вернется массив с информацией по нему, иначе по всем доступным странам
	 * @return array Список регионов
	 */
	public function getAreas(int $areaId = null): array
	{
		$url = self::API_URL.'areas/';
		if($areaId !== null) {
			$url .= $areaId.'/';
		}
		return $this->sendQuery($url);
	}

	/**
	 * Функция возвращает список всех районов
	 * 
	 * @param int $areaId ID региона или населенного пункта. Если указан, то вернется массив с районами этого региона, иначе со всеми районами
	 * @return array Список районов
	 */
	public function getDistricts(int $areaId = null): array
	{
		$url = self::API_URL.'districts/';
		$districts = $this->sendQuery($url);
		if($areaId !== null) {
			$districts = array_filter($districts, function($val) use($areaId) {
				return $val['area_id'] == $areaId;
			});
		}
		return $districts;
	}

	/**
	 * Функция возвращает информацию по работодателю
	 * 
	 * @return array|bool Массив с параметрами работодателя и false в случае, если id не указан
	 */
	public function getEmployer(): array|bool
	{
		if($this->employerId !== null) {
			$url = self::API_URL.'employers/'.$this->employerId;
		} else {
			return false;
		}
		return $this->sendQuery($url);
	}

	/**
	 * Функция посылает запрос по указанному УРЛу
	 * 
	 * @param $url URL запроса
	 * @return array Результат запроса
	 */
	private function sendQuery(string $url): array
	{
		$headers = [
			'Cache-Control: no-cache',
			'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
			'User-Agent: '.$this->productName.'/'.$this->productVersion.' ('.$this->email.')'
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return json_decode($output, true);
	}
}