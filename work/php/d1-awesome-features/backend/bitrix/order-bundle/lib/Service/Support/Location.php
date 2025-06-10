<?php

namespace App\Bundle\Order\Service\Support;

use Bitrix\Sale\Location\LocationTable;

class Location
{
	private int $zip;

	private int $depth = 0;

	private string $region;

	private string $city;

	private $db;

	private $code = false;

	public function __construct($zipCode, $region = '', $city = '')
	{
		global $DB;

		$this->db = $DB;
		$this->zip = intval($this->db->ForSql($zipCode));
		$this->region = $region;
		$this->city = $city;
	}

    public static function getZipByLocation(string|int $location): string|int|null
    {
        $data = LocationTable::getList([
            'filter' => [
                '=NAME.LANGUAGE_ID' => LANGUAGE_ID,
                'CODE' => $location
            ],
            'select' => ['ID', 'EXTERNAL']
        ]);

        return $data->fetch()['SALE_LOCATION_LOCATION_EXTERNAL_XML_ID'];
    }

	public static function new($zipCode, $region = '', $city = ''): Location
    {
		return new self($zipCode, $region, $city);
	}

	public function getCode()
	{
		$this->findCodeByZip();

		if (!$this->code) {
			$this->findCodeByRegionOrCity();
		}

		return $this->code;
	}

	private function findCodeByZip()
	{
		$result = $this->getZipQueryResult();

		while ($data = $result->Fetch()) {
			if (!$this->code && $data['CODE']) {
				$this->code = $data['CODE'];
				$this->depth = (int)$data['DEPTH_LEVEL'];
			}

			if ((int)$data['DEPTH_LEVEL'] > $this->depth && (int)$data['DEPTH_LEVEL'] < 4) {
				$this->code = $data['CODE'];
				$this->depth = (int)$data['DEPTH_LEVEL'];
			}
		}
	}

	private function getZipQueryResult()
	{
		$res = $this->db->Query('
			select loc.CODE, loc.DEPTH_LEVEL from b_sale_location loc
			left join b_sale_loc_ext zip on(zip.XML_ID = '. $this->zip .')
			where loc.ID = zip.LOCATION_ID
		');

		return $res;
	}

	private function findCodeByRegionOrCity()
	{
		$region = $this->getRegion();

		$city = $this->getCity($region['ID'] ?? null);

        if ($city['CODE'] || $region['CODE']) {
            $this->code = $city['CODE'] ?: $region['CODE'];
            return;
        }

        $cityAsRegion = $this->getCity(null, $this->region); //т.к г.Москва может прийти как регион, но в битриксе он записан как город

        if (isset($cityAsRegion['CODE']) && $cityAsRegion['CODE']) {
            $this->code = $cityAsRegion['CODE'];
        }
	}

	private function getRegion()
	{
		$res = LocationTable::getList([
			'filter' => [
				'=TYPE.ID' => '3',
				'=NAME.LANGUAGE_ID' => LANGUAGE_ID,
				'NAME.NAME' => '%'.$this->region.'%'
			],
			'select' => ['CODE', 'ID']
		]);

		return $res->fetch();
	}

	private function getCity($region_id, $city = '')
	{
        if (!$city) {
            $city = $this->city;
        }

        $filter = [
            '=TYPE.ID' => '5',
            '=NAME.LANGUAGE_ID' => LANGUAGE_ID,
            'NAME.NAME' => '%'.$city.'%',
        ];

        if ($region_id) {
            $filter['PARENT_ID'] = $region_id;
        }

		$res = LocationTable::getList([
			'filter' => $filter,
			'select' => ['CODE', 'ID']
		]);

		return $res->fetch();
	}
}
