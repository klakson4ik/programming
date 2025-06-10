<?php

namespace App\MoonShine;

use Illuminate\Auth\Access\HandlesAuthorization;
use MoonShine\Dashboard\DashboardBlock;
use MoonShine\Dashboard\DashboardScreen;
use MoonShine\Decorations\Button;

class Dashboard extends DashboardScreen
{
	use HandlesAuthorization;
	public static bool $withPolicy = true; 
	public function blocks(): array
	{
		return [
			DashboardBlock::make([
				Button::make(
					'Очистка кэша',
					route('cache-clear'),
					true
				)->icon('app'),
			]),
			DashboardBlock::make([
				Button::make(
					'Обновление вакансий',
					route('hh-update'),
					true
				)->icon('app')
			]),
		];
	}
}
