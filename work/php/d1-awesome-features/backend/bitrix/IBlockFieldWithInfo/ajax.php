<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use App\Bitrix\PropertyFields\IBlockElementWithInfo\Response;
use App\Bitrix\PropertyFields\IBlockElementWithInfo\Service;

if (Response::isAccept()) {
	$json = file_get_contents('php://input');
	$postData = json_decode($json, true);

	$props = explode(',', $postData['props']);

	$element = reset(Service::getElements([$postData['itemId']], $props, $postData['iblockId']));

	$data = Service::getPropsString($props, $element, $postData['delimiter'] ?: ' | ');
	if (!$data) {
		Response::returnFailed();
	}
	Response::returnSuccess(['text' => $data]);
}
Response::badRequest();
