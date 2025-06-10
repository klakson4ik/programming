# Бандл для работы с корзиной
Бандл разделен на два связанных класса:
- `BaseBasket` - класс для работы с корзиной
- `BaseBasketItem` - класс для работы с товаром в корзине

Базовые классы реализуют в себе основную логику для работы с одноименными сущностями, но с большей долей вероятности вам потребуется унаследовать их для ращирения под конкретный проект

Примеры реального использования можно посомтреть в директории `www/local/bundles/Basket/lib/Service/Savage`

## Корзина
Класс корзины реализует паттерн синглтон, для работы с ним нужно получить инстанс класса через метод `getInstance`

Корзина инициализуруется по FUser id, даже для авторизованных пользователей

Сам класс представляет собой методы для добавления, удаления, изменения и получения элементов корзины,
применения и удаления купонов и установку свойств корзины и товаров. Более детально можно посмотреть в описании phpdoc каждого метода в классе

### Пример использования

```php
use App\Bundle\Basket\Service\Base\BaseBasket;

$product_id_1 = 1001; // id торгового предложения
$product_id_2 = 1002; // id торгового предложения
$basket = BaseBasket::getInstance();

$basket->addProduct($product_id_1); // добавление продукта
// при  добавлении продукта сразу можно указать его количесвто, поля и свойства
$basket->addProduct($product_id_2, 5, ['LID' => 's1'], ['RAZMER' => 35]); 

// Не забывайте при изменении корзины сохранять ее
$basket->save();

$basket->changeItemQuantityByProductId($product_id_1, 4) // изменяет количесво товара
$basket->save();

$items = $basket->getItems(); // Получить массив с данными о товарах в виде объекта BaseBasketItem
$items = $basket->getItemsArray(); // Получить массив с данными о товарах в виде массива

$price = $basket->getPrice(); // Цена товаров в корзине
$weight = $basket->getWeight(); // Вес товаров в корзине
$items_count = $basket->getItemsCount(); // Кол-во товаров в коризне

$basket->removeItemByProductId($product_id_2); // убирает товар из корзины
$basket->clear(); // очищает корзину
$basket->save();

$coupon_1 = 'COUPON_TEST_1';
$coupon_2 = 'COUPON_TEST_2';

$basket->addCoupon($coupon_1); // Применение купона
$basket->addCoupon($coupon_2, true); // Применение купона с проверкой на сущесвование купона
$basket->getAppliedCoupons(); // вернет примененные купоны
$basket->getAppliedCoupons(true); // вернет примененные купоны с детальной информациие о кажом купоне

$discountPrice = $basket->getBasePrice() - $basket->getPrice();// Получение размера скидки
$basket->removeCoupon($coupon_2); // удаление купона
$basket->clearCoupons(); // удаление всех применненных купонов

$basket_data = $basket->toArray(); // Получение информации о корзине, включая и товары в ней, в виде массива

```

## Товар в корзине
Работа с товаром в корзине напрямую зависит от объекта корзины, в базовом виде это `BaseBasket`

### Пример работы с товаром
```php
// добавления товара в корзину и получение объекта товара
$product_id_1 = 1001; // id торгового предложения
$basket = BaseBasket::getInstance();
$basket->addProduct($product_id_1);
$item = $basket->getItemByProductId($product_id_1);

// изменение кол-ва товара
$item->setQuantity(2);
$item->save();

// получить свойства и поля товара в виде массива
$data = $item->toArray();

// получить доступное кол-во товара
$available_quantity = $item->available_quantity;

// можно ли купить товар
$can_buy = $item->can_buy;

// получить ссылку на товар в каталоге
$url = $item->product_url;

$id = $item->id; // id товара в корзине, не путайте с id торгового предложения и id товара

// получения цен товара, $base_price цена без учета скидок
$price = $item->price;
$base_price = $item->base_price;

// получить id торговорго предложения
$product_id = $item->product_id;

// получение свойств товара по коду
$size = $item->getPropertyByCode('RAZMER');

// получение свойств товара в корзине
$item_props = $item->properties;

// получение свойств товара(связанного с торговом предложением элемента ифноблока)
$product_props = $item->getProductPropertiesArray(); 

// получение суммы товара в корзине(цена * кол-во)
$sum = $item->sum;

// получение веса товара
$weight = $item->weight;

// получение имени товара
$name = $item->name;

// получение поля товара по коду
$name = $item->getField('NAME');

// удаление товара из корзины
$item->delete();
$item->save();
```

Более детальное описание всех возможностей посмотрите в классе `BaseBasketItem`





