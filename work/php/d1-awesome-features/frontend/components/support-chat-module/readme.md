# SupportChatModule
SupportChatModule - компанент для добавленния окна чат-бота поддержки на сайт.
Сообщения бота и ответы пользователя заранее прописаны в сценарии. 

## Подключение
Для подключения компонента нужно подключить скрипт и создать объект от класса "SupportChat"
с указанием пути до файла со сценарием и блоки далога и выбора ответов
Привер в файле index.html

```html
<head>
    <script src="/main.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
		const test = new SupportChat("/config.json", "content-area", "resp-area");
		});
    </script>
</head>
<body>
	<div class="content-area">
	</div>

	<div class="resp-area">
	</div>
</body>
```

## Составление сценария 
Сценарий диалога хранится в виде json файла с оределенной структурой
Привер в файле config.json

```json
"1": {                              // Ключ сообщения (Всегда начинается с 0) 
        "text": "Текст 1",          // Текст выводимый от лица бота (Может содержать теги и изображения)
        "options": [                // Вырианты ответа пользователя
            {
                "text": "Текст 2",  // Текст ответа
                "next_step": 2      // Ключ следующего сообшения
            },
        ]
    },
```

## Динамический текст ответа и ссылки 
Чтобы создать ajax зарос указывается тип ответа "ajax" и url куда будет отправлен запрос
Для ссылки указывается тип "link", url и текст ссылки 

```json
 "4": {
        "text": {
            "type": "ajax",
            "url": "/"
        },
        "options": [
            {
                "text": "Назад",
                "next_step": 0
            }
        ]
    },
    "3": {
        "text": {
            "text": "Ссылка",
            "type": "link",
            "url": "/"
        },
        "options": [
            {
                "text": "Назад",
                "next_step": 0
            }
        ]
    },
```
