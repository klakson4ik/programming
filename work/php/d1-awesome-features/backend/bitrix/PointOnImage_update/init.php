<?php
$eventManager = \Bitrix\Main\EventManager::getInstance();

/** Поля в административной панели */

/** Точки на картинке */
$pointOnImagesIblockField = new \App\Bitrix\Fields\PointOnImage\IBlockProperty();
$pointOnImagesHLBlockField = new \App\Bitrix\Fields\PointOnImage\HLBlockProperty();
$eventManager->addEventHandler("iblock", "OnIBlockPropertyBuildList", [$pointOnImagesIblockField, "GetUserTypeDescription"]);
$eventManager->addEventHandler("main", "OnUserTypeBuildList", [$pointOnImagesHLBlockField, "getDescription"]);