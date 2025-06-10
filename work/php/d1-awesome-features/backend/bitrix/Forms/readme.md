# Сервис для работы с формами

сервис состоит из следующих сущностей:
- Сама форма ([Пример рабочей формы](./Forms/FeedbackForm.php)), должна наследоваться от [абстрактной формы](./Forms/AbstractForm.php)
- Капчи ([google](./Captcha/GoogleCaptcha.php), [yandex](./Captcha/YandexCaptcha.php)) [Интерфейс](./Interfaces/CaptchaInterface.php)
- Хранилища, т.е. класс отвечающие за то, куда будут сохранены данный формы([bitrix формы](./Storages/WebFormStorage.php), [bitrix сервис подписок](./Storages/BitrixSubscribeStorage.php), [bitrix сервис техподдерки](./Storages/BitrixSupportStorage.php), инфоблок, сторонние сервисы и т.д), на одну форму может стоять несколько клаасов хранилищ [Интерфейс](./Interfaces/StorageInterface.php)
- Валидаторы (по умолчанию установлен только 1 валидатор от [Laravel](./Validators/Validator.php)) [Интерфейс](./Interfaces/ValidatorInterface.php)

У форм обязательно должны установлены валидатор и капча, сохранения формы опционально

Так же к данному сервису приложены классы, отвечающие за поля формы. С их помощью можно удобно рендерить форму и удобно ее валидировать, благодаря единому инферфесу [поля](./Fields/AbstractField.php)

Реальный примеры работы:
- [Сама форма](https://git.techart.ru/sites/tarkett.ru/-/blob/master/www/local/lib/Services/Forms/Forms/FeedbackForm.php?ref_type=heads)
- [Рендер формы](https://git.techart.ru/sites/tarkett.ru/-/blob/master/www/local/lib/Views/LayoutViews.php?ref_type=heads) (метод renderModalForm)
- [Обработка формы](https://git.techart.ru/sites/tarkett.ru/-/blob/master/www/local/bundles/Forms/lib/Controller/Forms.php?ref_type=heads) (метод feedbackHandle)

для корреткной работы нужно установить зависимости:
```json
{
  "require": {
    "php": ">=8.0",
    "illuminate/translation": "^10.41",
    "illuminate/validation": "^10.41",
    "elephox/mimey": "^4.0"
  }
}
```