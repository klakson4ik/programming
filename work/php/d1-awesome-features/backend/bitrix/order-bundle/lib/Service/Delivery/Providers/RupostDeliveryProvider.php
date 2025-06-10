<?php

namespace App\Bundle\Order\Service\Delivery\Providers;

use App\Bundle\Order\Service\Delivery\DTO\DeliveryProfileDTO;
use App\Bundle\Order\Service\Support\Enums\OrderProps;
use App\Bundle\Order\Service\Support\Enums\DeliveryType;
use App\Bundle\Order\Service\Support\Helper;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Sale\Delivery\Services\Manager;
use Bitrix\Sale\Location\LocationTable;
use Russianpost\Post\Optionpost;

//TODO: реализовать получение pvz в методе getPickupPoints()
class RupostDeliveryProvider extends AbstractDeliveryProvider
{
	protected static ?self $_instance = null;

	public int $id = 12;

	public string $name = 'rupost';

	public array $profiles = [
		[
			'id' => 13,
			'type' => DeliveryType::PICKUP_WIDGET
		]
	];

	protected string $module_id = 'russianpost.post';

	protected string $guid_id = '';

	protected int $address_property_id = OrderProps::PROPERTY_ADDRESS_ID;

	protected string $rupost_api = 'https://widget.pochta.ru/api/';

	protected string $rupost_api_pvz_points = 'api/pvz/index_public';

	protected string $rupost_api_pvz_point = 'api/pvz/show_public';

	protected string $key = 'ZS1tYXJrZXRAc2F2YWdlLnJ1OjExMXNhdmFnZVNUdnMxMTE=';

	protected string $token = 'ThZD6jePPgRqM_iH0ZNQS5oIZopOqblx';

	public function __construct(&$bitrix_order)
	{
		parent::__construct($bitrix_order);

		Loader::includeModule('russianpost.post');
		$this->guid_id = Option::get($this->module_id, "GUID_ID");
	}

	public static function getInstance(&$bitrix_order): static
	{
		return static::$_instance ??= new static($bitrix_order);
	}

	public function getProfileData(array $profile, bool $with_pickup_data = false): DeliveryProfileDTO
	{
		$calculateData = $this->calculateProfile($profile);

		$widget = $this->getPickupWidget(array_merge($calculateData, $profile));

		return DeliveryProfileDTO::fromArray([
			'id' => $profile['id'],
			'name' => $calculateData['shipment']->getDelivery()->getName(),
			'description' => $calculateData['shipment']->getDelivery()->getDescription(),
			'provider' => $this->name,
			'type' => $profile['type'],
			'price' => round($calculateData['calculate_result']->getDeliveryPrice(), 2),
			'delivery_time' => $calculateData['calculate_result']->getPeriodDescription(),
			'points' => [],
			'widget' => $widget
		]);
	}

	public function getPickupWidget(array $data): array
	{
		$service = Manager::getById($data['id']);

		$street_prop_id = 0;
		$house_prop_id = 0;
		$flat_prop_id = 0;
		$location = '';
		$bSplitAddress = false;
		$addressCode = Optionpost::get('address', true, SITE_ID);
		$selectPvz = 'N';

		if($addressCode == '') {
			$bSplitAddress = true;
		}

		foreach ($this->bitrix_order->getPropertyCollection() as $property) {
			if ($property->getField('CODE') === OrderProps::PROPERTY_LOCATION_CODE) {
				$location = $property->getValue();
				break;
			}
		}

		$res = LocationTable::getList([
			'filter' => [
				'CODE' => [$location],
			],
			'select' => [
				'EXTERNAL.*',
				'EXTERNAL.SERVICE.CODE'
			]
		]);

		$strZip = '';
		if ($location != '') {
			$arZip = [];

			while ($item = $res->fetch()) {
				if (
					$item['SALE_LOCATION_LOCATION_EXTERNAL_SERVICE_CODE'] == 'ZIP_LOWER'
					|| $item['SALE_LOCATION_LOCATION_EXTERNAL_SERVICE_CODE'] == 'ZIP'
				) {
					if (strlen($item['SALE_LOCATION_LOCATION_EXTERNAL_XML_ID']) > 3) {
						$threeDigits = substr($item['SALE_LOCATION_LOCATION_EXTERNAL_XML_ID'], 0, 3);
						$arZip[$threeDigits] = "'" . $threeDigits . "'";
					}
				}
			}

			$strZip = implode(", ", $arZip);
		}

		$orderWeight = (int)$this->bitrix_order->getBasket()->getWeight();
		$orderPrice = $this->bitrix_order->getPrice() * 100;
		$openMap = Option::get($this->module_id, "RUSSIANPOST_AUTOOPEN_CARD");
		$strError = json_encode($_SESSION['russianpost_post_calc']['errors'][$service['CONFIG']['MAIN']['SERVICE_TYPE']], JSON_UNESCAPED_UNICODE);

		$descr = '
		<div class="russianpost_link"><input type="hidden" id="russianpost_result_type" name="russianpost_result_type" value="">
			<input type="hidden" id="russianpost_result_price" name="russianpost_result_price" value="">
			<input type="hidden" id="russianpost_result_address" name="russianpost_result_address" value="">
			<input type="hidden" id="russianpost_street_address" name="russianpost_street_address" value="">
			<input type="hidden" id="russianpost_house_address" name="russianpost_house_address" value="">
			<input type="hidden" id="russianpost_flat_address" name="russianpost_flat_address" value="">
			<input type="hidden" id="russianpost_result_zip" name="russianpost_result_zip" value="">
			<input type="hidden" id="russianpost_address_prop" name="russianpost_address_prop" value="'.$this->address_property_id.'">
			<input type="hidden" id="russianpost_street_prop" name="russianpost_street_prop" value="'.$street_prop_id.'">
			<input type="hidden" id="russianpost_house_prop" name="russianpost_house_prop" value="'.$house_prop_id.'">
			<input type="hidden" id="russianpost_flat_prop" name="russianpost_flat_prop" value="'.$flat_prop_id.'">
			<input type="hidden" id="russianpost_set_readonly" name="russianpost_set_readonly" value="Y">
			<input type="hidden" id="russianpost_delivery_description" name="russianpost_delivery_description" value="">
			<input type="hidden" id="russianpost_select_pvz" name="russianpost_select_pvz" value="'.$selectPvz.'">
			<input type="hidden" id="russianpost_open_map" name="russianpost_open_map" value="'.$openMap.'">
			<input type="hidden" id="russianpost_full_map" name="russianpost_full_map" value="N">
			<input type="hidden" id="russianpost_split_address" name="russianpost_split_address" value="'.$bSplitAddress.'">
			<button
				id="russianpost_btn_openmap"
				onclick="
					event.preventDefault(); openMap(\''.$this->guid_id.'\', '.$orderPrice.','.$orderWeight.',['.$strZip.'], \''.$location.'\');
				"
				class="btn"
				style="border-color: #0055A6;
				background-color: #0055A6;
				color: #FFF;"
			>
				Открыть карту
			</button>
			<br>
			<span id="russianpost_select_address"></span>
		</div>';

		$descr .= "<input type='hidden' id='russianpost_error_txt' name='russianpost_error_txt' value='" . addslashes($strError) . "'>";

		return [
			'load' => [
				'/local/templates/site/js/pvzWidjet.js',
				'https://widget.pochta.ru/map/widget/widget.js'
			],
			'widget' => $descr
		];

	}

	public function getPickupPoints(mixed $data = null): array
	{
		$url = $this->rupost_api . $this->rupost_api_pvz_points;
		$params = [
			'order' => [
				'account_id' => $this->guid_id,
				'account_type' => 'other_cms',
				'shipping_address' => [
					'full_locality_name' => 'Россия, Тульская обл, г Тула',
					'location' => [
						'country' => $this->c,
						'region_zip' => '300000',
						'zip' => '300000',
					]
				],
				'items_price' => 5435,
				'total_weight' => 0.600
			]
		];

		$responce = $this->http_client->post($url, $params);

		vd($responce);

		return [];
	}

    public function getPropsByRequest(array $request, int $profile_id = 0): array
    {
		$errors = false;

        $validated_request['email'] = Helper::validateArrayKey($request, 'email', 'Не указан email');
        $validated_request['name'] = Helper::validateArrayKey($request, 'name', 'Не указано имя');
        $validated_request['phone'] = Helper::validateArrayKey($request, 'phone', 'Не указан телефон');
        $validated_request['address'] = Helper::validateArrayKey($request, 'address', 'Не указан адрес');
        $validated_request['russianpost_typedlv'] = Helper::validateArrayKey($request, 'russianpost_typedlv', 'Не указан тип доставки (Почта россиии)');
        $validated_request['zip'] = Helper::validateArrayKey($request, 'zip', 'Не указан индекс адресса доставки');

        foreach ($validated_request as $field) {
            if ($field['error']) {
                $errors = true;
                break;
            }
        }

        return [
            'request' => $validated_request,
            'errors' => $errors
        ];
    }
}