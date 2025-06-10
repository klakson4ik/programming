<?php

namespace App\Bitrix\PropertyFields\PointOnImage;


class PointOnImage
{
	use AssetTrait;

    public static function GetUserTypeDescription(): array
    {
        return array(
            "PROPERTY_TYPE" => "F",
            "USER_TYPE" => "MYIDCODE",
            "DESCRIPTION" => "Точки на изображении",
            'GetPropertyFieldHtml' => array(__CLASS__, 'GetPropertyFieldHtml'),
            "FILE_TYPE" => "jpg, gif, bmp, png, jpeg",
        );
    }

    public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName): string
    {


		$img = \CFile::GetPath($value["VALUE"]);

        return 
		self::addAssets().'
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

		<input type="file" name="' . $strHTMLControlName["VALUE"] . '" value="">
		<input type="hidden" name="' . $strHTMLControlName["DESCRIPTION"] . '" value="' . $value["DESCRIPTION"] . '">
		</div>
	';
    }

}
