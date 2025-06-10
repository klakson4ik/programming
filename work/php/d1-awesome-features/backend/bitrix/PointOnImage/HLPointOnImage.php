<?php

namespace App\Bitrix\PropertyFields\PointOnImage;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\FileInputUtility;
use CUserTypeManager;

class HLPointOnImage extends \Bitrix\Main\UserField\Types\FileType

{
    use AssetTrait;

    public const
    USER_TYPE_ID = 'point',
    RENDER_COMPONENT = 'bitrix:main.field.file';

    public static function getDescription(): array
    {
        return [
            'USER_TYPE_ID' => static::USER_TYPE_ID,
            'CLASS_NAME' => __CLASS__,
            'DESCRIPTION' => "Точки на изображении",
            'BASE_TYPE' => CUserTypeManager::BASE_TYPE_FILE,
        ];
    }

    public static function getDbColumnType(): string
    {
        return 'text';
    }

    public static function getEditFormHTML($arUserField, $arHtmlControl): string
    {
        $value = json_decode(stripcslashes(html_entity_decode(trim($arHtmlControl["VALUE"]))), true);

        $img = \CFile::GetPath($value['img']);
        $dots = json_encode($value['dots']);

        if ($dots == "null") {
            $dots = "";
        }

        return
        self::addAssets() . '
		<div class="dots">
		<div class="shadow">
		</div>
		<div class="modal">
		<div class="modal-area">
		<div class="area">
		<img src="' . $img . '">
		</div>
		<div class="inpcoord">
		<h2>Точки</h2>
		<div class="list">
		</div>
		</div>

		</div>
		<div class="modal-nav">
		<span class="popup-window-button popup-window-button-accept" id="">Готово</span>
		<span class="popup-window-button popup-window-button-link popup-window-button-link-cancel" id="">Удалить все</span>
		</div>
		</div>
		<img class="open-modal" src="' . $img . '">

		<br>
		<br>

		<input type="file" name="' . $arHtmlControl["NAME"] . '" value="">
		<input type="hidden" name="' . $arHtmlControl["NAME"] . '_disc" value="' . $dots . '">
		<input type="hidden" name="' . $arHtmlControl["NAME"] . '_old_img" value="' . $value['img'] . '">
		</div>
	';
    }

    public static function onBeforeSave(array $userField, $value)
    {
        // old mechanism
        if (is_array($value)) {
            $userFieldValues = (is_array($userField['VALUE']) ? $userField['VALUE'] : [$userField['VALUE']]);
            $valueHasOldId = !empty($value['old_id']);

            //Protect from user manipulation
            if ($valueHasOldId) {
                $value['old_id'] = (is_array($value['old_id']) ? $value['old_id'] : [$value['old_id']]);
                foreach ($value['old_id'] as $key => $oldId) {
                    if (!in_array($oldId, $userFieldValues)) {
                        unset($value['old_id'][$key]);
                    }
                }

                if ($value['del']) {
                    foreach ($value['old_id'] as $oldId) {
                        \CFile::Delete($oldId);
                    }
                    $value['old_id'] = false;
                }
            }

            if ($value['error']) {
                return self::addDots((is_array($value['old_id']) ? $value['old_id'][0] : $value['old_id']), $userField["FIELD_NAME"]);
            }

            if ($valueHasOldId) {
                foreach ($value['old_id'] as $oldId) {
                    \CFile::Delete($oldId);
                }
            }
            $value['MODULE_ID'] = 'main';

            if (!empty($value['name'])) {
                return self::addDots(\CFile::SaveFile($value, 'uf'), $userField["FIELD_NAME"]);
            }
            return false;
        }

        // new mechanism - mail.file.input
        $fileInputUtility = FileInputUtility::instance();
        $controlId = $fileInputUtility->getUserFieldCid($userField);

        if ($value > 0) {
            $delResult = $fileInputUtility->checkDeletedFiles($controlId);
            if (in_array($value, $delResult)) {
                return false;
            }

            if (is_array($userField['VALUE']) && in_array($value, $userField['VALUE'])) {
                return self::addDots($value, $userField["FIELD_NAME"]);
            }

            if (!is_array($userField['VALUE']) && (int) $userField['VALUE'] === $value) {

                return self::addDots($value, $userField["FIELD_NAME"]);
            }

            $checkResult = $fileInputUtility->checkFiles($controlId, [$value]);
            if (!in_array($value, $checkResult)) {
                $value = false;
            }
        }

        return self::addDots($value, $userField["FIELD_NAME"]);
    }

    public static function addDots($value, $name)
    {

        if ($value == null) {
            $value = $_REQUEST[$name . "_old_img"];
        }

        if (!is_array($value)) {
            $value = [
                "img" => $value,
                "dots" => json_decode($_REQUEST[$name . "_disc"]),
            ];
        }

        $value = json_encode($value);
        return $value;
    }
}
