# Работа с битриксовым сервисом техподдержки
Обретка над битриксовымы CTicketDictionary, CTicket

возможности:

- получать справочники подписок(по умолчанию их 7, но в админке можно добавлять больше)
- обновлять существующие обращения
- создавать новые обращения
- получать обращения по id
- получать историю сообщений и файлов в обращении
- получать список сообщений в обращении
- получать список файлов в обращении

Пример:
```php

$ticket = BitrixSupportService::instance()
    ->ticket
    ->getById((int)$arFields['ID']);

$ticketMessages = BitrixSupportService::instance()
    ->ticket
    ->getTicketMessages((int)$arFields['ID']);

$categoriesDictionary = BitrixSupportService::instance()->dictionary->getCategoryDictionary();
$otherDictionary = BitrixSupportService::instance()->dictionary->getDictionary(['TYPE' => 'test'])
```