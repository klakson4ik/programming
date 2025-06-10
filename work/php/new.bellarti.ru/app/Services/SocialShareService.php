<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;

class SocialShareService
{

	private $meta = [];
	private $currentUrl;

	public static function getData($meta, $listSocials)
	{
		$data = [];
		$class = new SocialShareService();
		$class->meta = $meta;
		$class->currentUrl = Request::getScheme() . '://' . $class->setCurrentUrl();

		foreach ($listSocials as $method) {
			if (method_exists(__CLASS__, $method)) {
				$data[$method] = $class->$method();
			}
		}

		return $data;
	}

	private function setCurrentUrl()
	{
		if (preg_match('/https?:\/\/(.+)/', url()->current(), $matches)) {
			return $matches[1];
		}
	}

	private function telegram()
	{
		return [
			"url" => 'https://t.me/share/url?url=' . urlencode($this->currentUrl) . '&text=' . urlencode($this->meta['description']) . '&utm_share=share2',
			"img" => getCommonIcon('tm'),
		];
	}

	private function vk()
	{
		return [
			"url" => 'https://vk.com/share.php?url=' . urlencode($this->currentUrl) . '&title=' . urlencode($this->meta['title']) . '&utm_share=share2',
			"img" => getCommonIcon('vk'),
		];
	}

	private function ok()
	{
		return [
			"url" => 'https://connect.ok.ru/offer?url=' . urlencode($this->currentUrl) . '&title=' . urlencode($this->meta['title']) . '&utm_share=share2',
			"img" => getCommonIcon('ok'),
		];
	}

	private function wa()
	{
		return [
			"url" => 'https://api.whatsapp.com/send?text=' . urlencode($this->meta['title']) . ' ' . urlencode($this->currentUrl) .  '&utm_source=share2',
			"img" => getCommonIcon('wa'),
		];
	}
}
