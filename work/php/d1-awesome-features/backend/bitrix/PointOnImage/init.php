<?php

$PointOnImage = new \App\Bitrix\PropertyFields\PointOnImage\PointOnImage();
AddEventHandler("iblock", "OnIBlockPropertyBuildList", [$PointOnImage, "GetUserTypeDescription"]);

$HLPointOnImage = new \App\Bitrix\PropertyFields\PointOnImage\HLPointOnImage();
addEventHandler('main', 'OnUserTypeBuildList', [$HLPointOnImage, 'getDescription']);
