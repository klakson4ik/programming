<?php

namespace App\Services;

use App\Helpers\ImageHelpers;
use Illuminate\View\View;

class HeaderService
{
	public function compose(View $view)
	{
		return $view->with('data', [
			'menu' => MenuService::getTopTree(),
			'logo' => ImageHelpers::getCommonIcon('logo'),
			'logo-solo' => [
				'icon' => ImageHelpers::getCommonIcon('solopharm'),
				'link' => 'https://solopharm.com'
			]
		]);
	}
}
