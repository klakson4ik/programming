<?php

namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Helpers\SiteHelpers;
use App\Models\Common;
use Illuminate\View\View;

class FooterService
{
	private $common = [];
	public function compose(View $view)
	{
		$this->init();
		return $view->with('data', [
			'menu' => MenuService::getBottomTree(),
			'contact-us' => $this->getContactUs(),
			'under' => $this->getUnder(),
			'bg' => ImageHelpers::getCommonImage('footer-bg.png'),
			'levelMax' => 2,
			'techart' => '<a class="c-link-underline b-footer-techart__link c-link-base" href="https://design.techart.ru/" target="_blank">Дизайн</a>, <a
        class="c-link-underline b-footer-techart__link c-link-base" href="https://web.techart.ru/ " target="_blank">разработка и сопровождение
        сайта</a> — <a class="c-link-underline b-footer-techart__link c-link-base" href="https://techart.ru/" target="_blank">Текарт</a><span>.</span>'
		]);
	}

	private function init()
	{
		$this->common = Common::getByCodes(['phone-main', 'mail-info', 'address-office', 'address-production', 'link-footer-youtube', 'link-footer-vk', 'link-footer-tm'])->toArray();
	}

	private function getContactUs()
	{
		return [
			'title' => 'Связаться с нами:',
			'phone' => [
				'text' => $this->common['phone-main']['value'],
				'link' => SiteHelpers::getPhoneHref($this->common['phone-main']['value'])
			],
			'mail' => $this->common['mail-info']['value'],
			'office' => [
				'caption' => 'Офис',
				'value' => $this->common['address-office']['value']
			],
			'production' => [
				'caption' => 'Производство',
				'value' => $this->common['address-production']['value']
			],
			'feedback' => [
				'caption' => 'Задать вопрос',
				'link' => '/feedback'
			]
		];
	}

	private function getUnder()
	{
		return [
			'solopharm' => [
				'caption' => 'SOLOPHARM',
				'icon' => ImageHelpers::getCommonIcon('arrow-footer'),
				'link' => 'https://solopharm.com'
			],
			'youtube' => [
				'caption' => 'Подписывайтесь',
				'icon' => ImageHelpers::getCommonIcon('youtube'),
				'link' => $this->common['link-footer-youtube']['value']
			],
			'vkontakte' => [
				'caption' => 'Подписывайтесь',
				'icon' => ImageHelpers::getCommonIcon('vk'),
				'link' => $this->common['link-footer-vk']['value']
			],
			'telegram' => [
				'caption' => 'Подписывайтесь',
				'icon' => ImageHelpers::getCommonIcon('tm'),
				'link' => $this->common['link-footer-tm']['value']
			],
			'policy' => [
				'caption' => 'Политика Конфиденциальности',
				'link' => '/policy',
			],
			'stamp' => '© BELLARTI ' . date('Y')
		];
	}
}
