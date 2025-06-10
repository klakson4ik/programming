<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\CityResource;
use App\MoonShine\Resources\ClinicalExampleResource;
use App\MoonShine\Resources\CommonResource;
use App\MoonShine\Resources\EventResource;
use App\MoonShine\Resources\CosmetologyResource;
use App\MoonShine\Resources\ExpertResource;
use App\MoonShine\Resources\HomeSliderResource;
use App\MoonShine\Resources\AboutSliderResource;
use App\MoonShine\Resources\MenuResource;
use App\MoonShine\Resources\VideosResource;
use App\MoonShine\Resources\ProductsResource;
use App\MoonShine\Resources\FAQResource;
use App\MoonShine\Resources\CombinedProtocolsResource;
use App\MoonShine\Resources\BlogResource;
use App\MoonShine\Resources\PartnersResource;
use App\MoonShine\Resources\PeopleResource;
use App\MoonShine\Resources\DistrictsResource;
use App\MoonShine\Resources\ClinicResource;
use App\MoonShine\Resources\PublicationsResource;
use App\MoonShine\Resources\OffersResource;
use App\MoonShine\Resources\NewsResource;

use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Menu\MenuElement;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;
use MoonShine\Contracts\Resources\ResourceContract;
use MoonShine\Pages\Page;

use Closure;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
	/**
	 * @return list<ResourceContract>
	 */
	protected function resources(): array
	{
		return [];
	}

	/**
	 * @return list<Page>
	 */
	protected function pages(): array
	{
		return [];
	}

	/**
	 * @return Closure|list<MenuElement>
	 */
	protected function menu(): array
	{
		return [
			MenuGroup::make(static fn() => __('moonshine::ui.resource.system'), [
				MenuItem::make(
					static fn() => __('moonshine::ui.resource.admins_title'),
					new MoonShineUserResource()
				),
				MenuItem::make(
					static fn() => __('moonshine::ui.resource.role_title'),
					new MoonShineUserRoleResource()
				),
			]),
			MenuGroup::make('Основное', [
				MenuItem::make(
					'Меню',
					new MenuResource()
				),
				MenuItem::make(
					'Общие',
					new CommonResource()
				),
			]),
			MenuGroup::make('Медиа', [
				MenuItem::make(
					'Блог',
					new BlogResource()
				),
				MenuItem::make(
					'Новости',
					new NewsResource()
				),
				MenuItem::make(
					'События',
					new EventResource()
				),
				MenuItem::make(
					'События косметологии',
					new CosmetologyResource()
				),
			]),

			MenuGroup::make(static fn() => "Торговое предложение", [
				MenuItem::make(
					'Товары',
					new ProductsResource()
				),
				MenuItem::make(
					'Торговые предложения',
					new OffersResource()
				),
			]),

			MenuItem::make(
				'Партнёры',
				new PartnersResource()
			),


			MenuGroup::make(static fn() => 'Регион и представители', [
				MenuItem::make(
					'Региональные представители',
					new PeopleResource()
				),

				MenuItem::make(
					'Регион',
					new DistrictsResource()
				),
			]),

			MenuItem::make(
				'FAQ',
				new FAQResource()
			),

			MenuItem::make(
				'Сочетанные протоколы',
				new CombinedProtocolsResource()
			),

			MenuItem::make(
				'Блок "Публикации"',
				new PublicationsResource()
			),

			MenuGroup::make('Общие', [
				MenuItem::make(
					'Видео',
					new VideosResource()
				),
				MenuItem::make(
					'Города',
					new CityResource()
				),
				MenuItem::make(
					'Клиники',
					new ClinicResource()
				),
			]),
			MenuGroup::make('Верхние слайдеры', [
				MenuItem::make(
					'Слайдер "Главная"',
					new HomeSliderResource()
				),
				MenuItem::make(
					'Слайдер "О нас"',
					new AboutSliderResource()
				),
			]),
			MenuGroup::make('Косметология', [
				MenuItem::make(
					'Клинические примеры',
					new ClinicalExampleResource()
				),
				MenuItem::make(
					'Эксперты',
					new ExpertResource()
				)
			]),
		];
	}

	/**
	 * @return Closure|array{css: string, colors: array, darkColors: array}
	 */
	protected function theme(): array
	{
		return [];
	}
}
