<?php

namespace App\Bitrix\Fields\PointOnImage;

use Bitrix\Main\Page\Asset;
use Bitrix\Main\UI\Extension;
use CFile;

trait FieldTrait
{
	protected static string $imageFieldSuffix = '-image';
	protected static string $imageIdSuffix = '-image-id';
	protected static string $imageFlagSuffix = '-image-new';

	protected static function addAssets(): string
	{
		Extension::load("ui.buttons");
		Extension::load("ui.forms");

		$assetsPath = '/local/lib/Bitrix/Fields/PointOnImage/assets/';
		$v = md5(date("h:i:s"));

		Asset::getInstance()->addJs($assetsPath . 'modal.js', true);
		Asset::getInstance()->addJs($assetsPath . 'dots.js', true);
		Asset::getInstance()->addJs($assetsPath . 'script.js', true);

		return
			'<link rel="stylesheet" media="screen" type="text/css" href="' . $assetsPath .'modal.css?v='. $v .'" />'.
			'<link rel="stylesheet" media="screen" type="text/css" href="' . $assetsPath .'dots.css?v='. $v .'" />'.
			'<link rel="stylesheet" media="screen" type="text/css" href="' . $assetsPath .'style.css?v='. $v .'" />'.
			''
		;
	}

	protected static function render($value, $propId, $name): string
	{
		$data = '';
		$img = '';
		$img_id = 0;

		if (is_array($value)) {
			$data = json_encode(json_decode_from_html($value['data']), JSON_UNESCAPED_UNICODE);
			$img_id = $value['image_id'];
			$img = CFile::GetPath($img_id);
		}

		$new = $img ? 'N' : 'Y';
		$modal_id = $propId.'-image-points-'.random_int(0, 9999);
		$remove = '';

		if ($img) {
			$remove =
				'<button class="ui-btn ui-btn-danger delete" type="button" data-remove-img="1">'.
				'Удалить изображение'.
				'</button>';
		}

		return
			'<div class="dots-field" data-modal-id="'.$modal_id.'">'.
				'<textarea style="display: none;" data-value="1" name="' . $name . '">'.$data.'</textarea>'.
				'<button class="dots-field__button" type="button" title="Установить попапы" aria-controls="'.$modal_id.'">'.
				'<img data-image="1" src="'.$img.'">'.
				'</button>'.
				'<input class="dots-field__file" data-file="1" type="file" name="'.$propId. self::$imageFieldSuffix .'">'.
				'<input type="hidden" data-image-id="1" name="'.$propId.self::$imageIdSuffix.'" value="'.$img_id.'">'.
				'<input data-flag="1" type="hidden" name="'.$propId. self::$imageFlagSuffix . '" value="'. $new .'">'.
				$remove.
			'</div>'
		;
	}

	protected static function serialize($propId, $value): string
	{
		$imageId = null;

		if ((int)$_REQUEST[$propId.self::$imageIdSuffix] !== 0) {
			$imageId = (int)$_REQUEST[$propId.self::$imageIdSuffix];
		}

		if (
			$_REQUEST[$propId.self::$imageFlagSuffix] === 'Y'
			&& $_FILES[$propId.self::$imageFieldSuffix]
		) {
			$imageId = CFile::SaveFile($_FILES[$propId.self::$imageFieldSuffix], 'image-points');
		}

		return serialize([
			'image_id' => $imageId,
			'data' => $value
		]);
	}

	protected static function unserialize_from_html(string $str, array $options = [])
	{
		return unserialize(
			stripcslashes(html_entity_decode(trim($str))),
			$options
		);
	}
}