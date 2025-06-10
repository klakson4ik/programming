# Forms.

## Описание
Шаблоны для создания форм
- [yandex-captcha](./fields/ycaptcha/ycaptcha.blade.php)
- [google-catcha](./fields/gcaptcha/gcaptcha.blade.php)
- [select](./fields/select/select.blade.php)
- [input-tel](./component/PhoneMask.js) маска страны подстраиватся автоматически в зависимости от введеных первых символов. Удаление символов из любой позиции курсора. Режим Paste.
- [input-file](./fields/input-file/input-file.blade.php) с листом загруженных файлов. Добавлен режим превью для изображений
- [input](./fields/input/input.blade.php)
- [checkbox](./fields/checkbox/checkbox.blade.php)
- [checkbox-group](./fields/checkbox-group/checkbox-group.blade.php)
- [radio-group](./fields/radio-group/radio-group.blade.php)

## Инструкция
- Подключить необходимые поля из директории [fildes](./fields/), главный стандартный шаблон формы [forms/default](./forms/default/) и components
- В js файлах поменять импорты в соответствии с струкрурой сайта.
- Для определенного движка в файлах [forms/defalut.php](./forms/default/default.blade.php#L7) и [fields/checkbox-group](./fields/checkbox-group/checkbox-group.blade.php#L22) оставить свойтсвтенные методы подключения шаблонов, так же поправить пути до конечных файлов в соответсвии структуре проекта
- Пример создания полей формы в файле [index.php](./index.php)
- Каждое поле может быть required, disabled
- Для создания правил валидации нужно добавить в [метод #check](./component/Validate.js#L28) selector выборки полей и в соответствии с другими правилами добавить свое правило 
- Информация по Настройки и действиям формы в файле [Form.js](./component/Form.js)
- Для редактирования телефонных кодов используется [файл](./component/codes/codes.json) ключ - код страны, значение - маска(цифры количество знаков)
- [файл](./component/codes/codes-full.json) для расширения фунцкионала телефонной маски