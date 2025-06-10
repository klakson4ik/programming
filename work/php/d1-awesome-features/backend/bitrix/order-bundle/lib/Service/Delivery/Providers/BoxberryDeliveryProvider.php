<?php

namespace App\Bundle\Order\Service\Delivery\Providers;

use App\Bundle\Order\Service\Delivery\DTO\DeliveryPointDTO;
use App\Bundle\Order\Service\Delivery\DTO\DeliveryProfileDTO;
use App\Bundle\Order\Service\Support\Enums\DeliveryType;
use App\Bundle\Order\Service\Support\Helper;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use CDeliveryBoxberry;

//TODO: реализация валидации индекса
class BoxberryDeliveryProvider extends AbstractDeliveryProvider
{
    protected static ?self $_instance = null;

    protected bool $pickup_include_postamat = true;

    protected bool $pickup_only_prepaid = false;

    protected string $boxberry_api = 'https://api.boxberry.ru/json.php';

    protected string $token;

    protected string $module_id = 'up.boxberrydelivery';

    protected string $country_code = '643';

    public int $id = 5;

    public string $name = 'boxberry';

    public array $profiles = [
        [
            'id' => 8,
            'type' => DeliveryType::PICKUP
        ],
        [
            'id' => 10,
            'type' => DeliveryType::COURIER
        ]
    ];

    public function __construct(&$bitrix_order)
    {
        parent::__construct($bitrix_order);

        $this->loadBoxberryModule();
        $this->token = trim(Option::get($this->module_id, 'API_TOKEN'));
    }

    public static function getInstance(&$bitrix_order): static
    {
        return self::$_instance ??= new self($bitrix_order);
    }

    public function getProfileData(array $profile, bool $with_pickup_data = false): DeliveryProfileDTO
    {
        $calculateData = $this->calculateProfile($profile);

        $points = [];

        if ($with_pickup_data && $profile['type'] === DeliveryType::PICKUP) {
            $points = $this->getPickupPoints([
                'price' => round($calculateData['calculate_result']->getDeliveryPrice(), 2),
                'location' => $this->bitrix_order->getPropertyCollection()->getDeliveryLocation()->getValue(),
                'delivery_time' => $calculateData['calculate_result']->getPeriodDescription()
            ]);
        }

        return DeliveryProfileDTO::fromArray([
            'id' => $profile['id'],
            'name' => $calculateData['shipment']->getDelivery()->getName(),
            'description' => $calculateData['shipment']->getDelivery()->getDescription(),
            'provider' => $this->name,
            'type' => $profile['type'],
            'price' => round($calculateData['calculate_result']->getDeliveryPrice(), 2),
            'delivery_time' => $calculateData['calculate_result']->getPeriodDescription(),
            'points' => $points,
            'widget' => []
        ]);
    }

    public function getPickupPoints(mixed $data = null): array
    {
        CDeliveryBoxberry::getBitrixRegionNames($data['location']);
        $cityCode = CDeliveryBoxberry::getCityCode();
        $url = $this->makeUrl($cityCode);

        $response = $this->http_client->get($url);
        $points = json_decode($response, true);

        return array_map(function ($item) use ($data) {
            return DeliveryPointDTO::fromArray([
                'code' => $item['Code'],
                'address' => $item['Address'],
                'phone' => $item['Phone'],
                'description' => $item['TripDescription'],
                'coords' => explode(',', $item['GPS']),
                'provider' => $this->name,
                'work_time' => $item['WorkShedule'],
                'price' => $data['price'],
                'delivery_time' => $data['delivery_time'],
                'extra' => [
                    'weight_limit' => (int)$item['LoadLimit'] * 1000,
                    'volume_limit' => $item['VolumeLimit'],
                    'tmp' => $item
                ]
            ]);
        }, $points);
    }

    protected function makeUrl($city_code): string
    {
        return sprintf('%s?token=%s&method=ListPoints&prepaid=%s&CountryCode=%s&CityCode=%s&is_include_postamat=%s',
            $this->boxberry_api,
            $this->token,
            $this->pickup_only_prepaid ? '1' : '0',
            $this->country_code,
            $city_code,
            $this->pickup_include_postamat ? '1' : '0'
        );
    }

    protected function loadBoxberryModule(): void
    {
        Loader::includeModule($this->module_id);
        CDeliveryBoxberry::init();
    }

    public function getPickupWidget(array $data): array
    {
        return [];
    }

    public function getPropsByRequest(array $request, int $profile_id = 0): array
    {
        $profile = $this->profiles[array_search($profile_id, array_column($this->profiles, 'id'))];
        $errors = false;

        $validated_request['email'] = Helper::validateArrayKey($request, 'email', 'Не указан email');
        $validated_request['name'] = Helper::validateArrayKey($request, 'name', 'Не указано имя');
        $validated_request['phone'] = Helper::validateArrayKey($request, 'phone', 'Не указан телефон');
        $validated_request['address'] = Helper::validateArrayKey($request, 'address', 'Не указан адрес');

        if ($profile && $profile['type'] === DeliveryType::PICKUP) {
            $validated_request['boxberry_pvz_code'] = Helper::validateArrayKey($request, 'boxberry_pvz_code', 'Не выбран пункт выдачи boxberry');
            $validated_request['address']['value'] = 'Boxberry: ' . $validated_request['address']['value'] . '#' . $validated_request['boxberry_pvz_code']['value'];
        }

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