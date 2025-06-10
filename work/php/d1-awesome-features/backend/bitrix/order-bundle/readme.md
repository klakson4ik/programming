# Бандл работы с заказами битрикс.

## Работа со службами доставки
Работа с доставками ощуествляется через класс `DeliveryManager`

Каждую службу доставки на сайте необходимо зарегистрировать через это менеджер.

Для этого создается класс провайдера доставки, наследующий базовый провайдер и его неймспейс
указвывается в свойстве класса `DeliveryManager` `$providers_list`

Для демонстрации уже созданы два провайдера для служб доставок:
- `Order/lib/Service/Delivery/Providers/BoxberryDeliveryProvider.php` - провайдер для работы с службой доставки boxberry
- `Order/lib/Service/Delivery/Providers/RupostDeliveryProvider.php` - провайдер для работы с службой доставки Почта россии

## Пример создания провайдера службы доставки
1. Создать унаследованный от `AbstractDeliveryProvider` класс.
2. Установить id службы доставки
3. Установить имя(код) службы доставки
4. Установить массив с информацией о профилях доставки
5. Реализовать методы `getPickupPoints`, `getPickupWidget`, `getPropsByRequest`
6. Зарегистрировать его в менеджере.


```php
use App\Bundle\Order\Service\Delivery\Providers\AbstractDeliveryProvider;
use App\Bundle\Order\Service\Support\Enums\DeliveryType;

class CustomDeliveryProvider extends AbstractDeliveryProvider
{
    public int $id = 5; // id службы доставки в битрикс
    
    public string $name = 'custom';
    
    public array $profiles = [
        [
            'id' => 8,
            'type' => DeliveryType::PICKUP // тип доставки самовывоз, с собственным полученим пунктов для карты
        ],
        [
            'id' => 9,
            'type' => DeliveryType::PICKUP_WIDGET// тип доставки курьер, с полученим виджета карты
        ],
        [
            'id' => 10,
            'type' => DeliveryType::COURIER// тип доставки курьер
        ]
    ];
    
    // Метод реализующий получение точек на карте
    // и приведение их к одному виду с помощью класса DeliveryPointDTO
    public function getPickupPoints(array $data) : array
    {
        ...//реализация получения точек на карте
        $points; // точки на карте
        
        return array_map(function ($point) {
            return DeliveryPointDTO::fromArray([
                'code' => $point['code'],
                'address' => $point['address'],
                'phone' => $point['phone'],
                'description' => $point['desc'],
                'coords' => $point['coords'],
                'provider' => $point['provider'],
                'work_time' => $point['work_time'],
                'price' => $point['price'],
                'delivery_time' => $point['delivery_time'],
                'extra' => []
            ]);
        }, $points); 
    }
    
    public function getPickupWidget(array $data) : array
    {
        ...//реализация получения виджета
        
        return [
            'load' => [ // скрипты и стили, которые необходимо загрузить для работы виджета
                '/local/templates/site/js/widget.js',
                '/local/templates/site/css/widget.css',
                'https://code.jquery.com/jquery-3.7.0.slim.min.js'
            ],
            'widget' => $widget // виджет в виде html 
        ];
    }
    
    public function getPropsByRequest(array $request, int $profile_id = 0) : array
    {
        // реализация валидации и подстановки необходимый свойств заказа для данной доставки
        
        $validated_request['phone'] = Helper::validateArrayKey($request, 'phone', 'Не указан телефон');
        $validated_request['address'] = Helper::validateArrayKey($request, 'address', 'Не указан адрес');

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


class DeliveryManager
{
    ...
    protected array $providers_list = [
        CustomDeliveryProvider::class
    ];
    ...
}
```

## получение точк на карте для досатвки

1. Необходимо выставить заказу необходимые поля: местоположение(иногда индекс, смотреть нужно от службы доставки)
2. Найти провайдера службы доставки
3. Вызвать у него метод `getProfileData` с 2 аргуметом `true`

### Пример

```php
use App\Bundle\Order\Service\Order\BaseOrder;
use App\Bundle\Order\Service\Delivery\DeliveryManager;
use App\Bundle\Order\Service\Support\Enums\DeliveryType;
use App\Bundle\Order\Service\Delivery\DTO\DeliveryPointDTO;

/**
 * @var array $request 
 * @var \Bitrix\Sale\Basket $basket
 */

$order = BaseOrder::getInstance()
    ->create($basket);

$order->setLocation($request['location']);

$delivery_manager = DeliveryManager::getInstance();
$delivery_provider = $delivery_manager->getProviderByName($request['delivery_name']);
$profile = $delivery_provider->getProfileData([
    'id' => $request['delivery_id'],
    'type' => DeliveryType::PICKUP,
], true);

/**
* @var DeliveryPointDTO[] $points массив с инфромцаией о точке на карте
 */
$points = $profile->points;
```

# Создание и работа с заказом

Пример создания заказа:
```php
/** @var \Bitrix\Sale\Basket $basket */

$order = BaseOrder::getInstance()
    ->create();
    
// установить корзину
$order->setBasket($basket);

// корзину можно передать сразу в метод create
$order = BaseOrder::getInstance()
    ->create($basket);
```

Пример получение сущесвующего заказа:
```php
$order_id = 654;
$order = BaseOrder::load($order_id);
```

Пример работы с заказом заказа:
```php
//Создание

/** 
 * @var \Bitrix\Sale\Basket $basket 
 * @var array $request 
 */
 
 use App\Bundle\Order\Service\Delivery\DeliveryManager;
 use App\Bundle\Order\Service\Order\BaseOrder;

$order = BaseOrder::getInstance()
    ->create($basket);

//устновка свойста местоположения, рекомендуется устанавливать как можно раньше
$order->setLocation($request['location']);

//объект для работы с провайдерами служб доставки
$delivery_manager = DeliveryManager::getInstance($order->bitrix_order);


// получение доступных служб доставок, учитывая ограничения
$deliveries = $delivery_manager
    ->getAvailableDeliveries();

// получение необходимой службы доставки по id
$delivery = $delivery_manager->getProviderById((int)$request['delivery_id'])

// установка службы доставки в заказ
$order->setDelivery($delivery->id, $delivery->name);
// при необходимости можно сразу установить цену доставки
$order->setDelivery($delivery->id, $delivery->name, 450.00);

// получение доступных служ оплаты, учитывая ограничения
$payments = $order->getAvailablePaySystems();

// установка необходимой службы оплаты 

foreach ($payments as $payment) {
    if ($payment->pay_system_id === (int)$request['payment_id']) {
        $this->order->setPayment($payment->pay_system_id, $payment->name);
    }
}

// получение цен
$prices = [
    'price' => $order->getPrice(), // цена с учетом скидок и доставки
    'base' => $order->getBasePrice(), // цена с учетом доставки
    'delivery' => $order->getDeliveryPrice(), // цена доставки
    'discount' => $order->getDiscountPrice(), // скида
    'basket_price' => $order->getBasketPrice(), // цена корзины(товаров)
    'basket_base_pirice' => $order->getBasketBasePrice(), // цена корзины(товаров), без учета скидки
];

// получение выбранной службы доставки
$selected_delivery_id = $order->getSelectedDeliveryId();

// получение выбранной службы оплаты
$selected_payment_id = $order->getSelectedPaySystemId();

// получение свойства "индекс"
$zip = $order->getZip();

// получение свойства "местоположение"
$location = $order->getLocation();

// получение полей заказа в виде массива
$fields_array = $order->getFieldsArray();

// получение поля заказа по коду
$some_field = $order->getField('FIELD_CODE');

// получение свойства заказа по коду
$some_prop = $order->getPropertyByCode('SOME_PROP');

// получить статус заказа
$status = $order->getStatus();

// применить скидки к заказу, если при создании заказа была сразу передана корзина,
//то скидки применяются автоматически
$order->applyDiscount();

// получить трек номер отгрузки заказа
$track_number = $order->getDeliveryTrackCode();

// колекции отгрузок, свойств и систем оплаты можно получить следущими методами
$payment_collection = $order->getPaymentCollection();
$shipment_collection = $order->getShipmentCollection();
$property_collection = $order->getPropertyCollection();

// устанивть статус
$order->setStatus('N');

// установить поле заказа по коду
$order->setField('FILED_CODE', 'value');

// установить несколько полей заказа по коду
$order->setFields([
    'FIELD_1' => 34
    'FIELD_2' => 'value'
]);

// установить тип лательшика
// стандартно устанавливается тип: 1
$order->setPersonTypeId(1);

// устанавливает покупателя по id пользователя 
$order->setUser(10);

// устанвока свойств:
// массивом, ключи(код свойства) могут быть как в нижеми, так и вверхнем регистре
// ключи они автоматически переводятся в верхний регстр
$order->setPropertiesByArray([
    'LOCATION' => '453235',
    'zip' => '4324543'
]);

// по id свойств
$order->setPropertyById(4, '453235');

// по коду свойства
$order->setPropertyByCode('LOCATION', '453235');
```

## Вспомогательные классы для работы с заказом и доставками

`Order/lib/Service/Delivery/DTO/DeliveryPointDTO` - Класс, содержащий в себе необходимые стандартизированые поля для построения точки на карте

`Order/lib/Service/Delivery/DTO/DeliveryProfileDTO` - Класс, содержащий в себе необходимые стандартизированые поля для профиля службы доставки

`Order/lib/Service/Order/DTO/PaySystemDTO` - Класс, содержащий в себе необходимые стандартизированые поля для службы оплаты

`Order/lib/Service/Support/Enums/DeliveryType` - Класс, содержащий в себе константы типов доставки

`Order/lib/Service/Support/Enums/OrderProps` - Класс, содержащий в себе константы id и кодов свойств заказа

`Order/lib/Service/Support/Location` - Класс, позволяющий находить местоположения по идексу и наоборот

`Order/lib/Service/Support/Helper` - Класс, позволяющий находить местоположения по идексу и наоборот

