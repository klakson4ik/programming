<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\AchievementResource;
use App\MoonShine\Resources\ArrangementResource;
use App\MoonShine\Resources\BiotechEquipmentResource;
use App\MoonShine\Resources\BiotechPageResource;
use App\MoonShine\Resources\CacheResource;
use App\MoonShine\Resources\CerfificatePageResource;
use App\MoonShine\Resources\CertificateResource;
use App\MoonShine\Resources\ChronologyResource;
use App\MoonShine\Resources\ClubPageResource;
use App\MoonShine\Resources\ContactResource;
use App\MoonShine\Resources\ContractualPageResource;
use App\MoonShine\Resources\CountryResource;
use App\MoonShine\Resources\DevelopmentResource;
use App\MoonShine\Resources\DirectionResource;
use App\MoonShine\Resources\EquipmentPageResource;
use App\MoonShine\Resources\EquipmentPreparationResource;
use App\MoonShine\Resources\EquipmentResource;
use App\MoonShine\Resources\FormPageResource;
use App\MoonShine\Resources\FormResource;
use App\MoonShine\Resources\GalleryPageResource;
use App\MoonShine\Resources\GalleryResource;
use App\MoonShine\Resources\GallerySiteResource;
use App\MoonShine\Resources\InfoResource;
use App\MoonShine\Resources\InternshipPageResource;
use App\MoonShine\Resources\LabdirectionResource;
use App\MoonShine\Resources\LabinternshipPageResource;
use App\MoonShine\Resources\LegalPageResource;
use App\MoonShine\Resources\LegalResource;
use App\MoonShine\Resources\LegalSiteResource;
use App\MoonShine\Resources\LiquidplantPageResource;
use App\MoonShine\Resources\LocationResource;
use App\MoonShine\Resources\MainPageResource;
use App\MoonShine\Resources\MarketPageResource;
use App\MoonShine\Resources\MenuResource;
use App\MoonShine\Resources\NewsPageResource;
use App\MoonShine\Resources\NewsResource;
use App\MoonShine\Resources\PremiseResource;
use App\MoonShine\Resources\PressResource;
use App\MoonShine\Resources\ProductPageResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\ProjectResource;
use App\MoonShine\Resources\ProviderPageResource;
use App\MoonShine\Resources\RndPageResource;
use App\MoonShine\Resources\SiteResource;
use App\MoonShine\Resources\SitesPageResource;
use App\MoonShine\Resources\SoftFormPlantPageResource;
use App\MoonShine\Resources\SolidplantPageResource;
use App\MoonShine\Resources\SolidplantSystemResource;
use App\MoonShine\Resources\SupplementFormResource;
use App\MoonShine\Resources\SupplementPageResource;
use App\MoonShine\Resources\TechnologyPageResource;
use App\MoonShine\Resources\TechnologyResource;
use App\MoonShine\Resources\TenderPageResource;
use App\MoonShine\Resources\TodayResource;
use App\MoonShine\Resources\TradeResource;
use App\MoonShine\Resources\VacancyPageResource;
use App\MoonShine\Resources\VacancyResource;
use App\MoonShine\Resources\ValuePageResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{

	private $adminIds = [1, 2];

	public function boot(): void
	{
		app(MoonShine::class)->menu([
			MenuGroup::make('Админ-панель', [
				MenuItem::make('Пользователи', new MoonShineUserResource())
					->icon('users'),
				MenuItem::make(__('moonshine::ui.resource.role_title'), new MoonShineUserRoleResource())->icon('bookmark')->canSee(
					fn () =>
					in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
				)
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::ui.resource.system'), [
				MenuItem::make('Меню', new MenuResource())
					->icon('app'),
				MenuItem::make('Информация', new InfoResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),

			MenuGroup::make(__('moonshine::section.main.title'), [
				MenuItem::make(__('moonshine::section.static'), new MainPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.main.dynamic.development'), new DevelopmentResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.main.dynamic.direction'), new DirectionResource())
					->icon('app'),

				MenuItem::make(__('moonshine::section.main.dynamic.projects'), new ProjectResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.value.title'), [
				MenuItem::make(__('moonshine::section.static'), new ValuePageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.value.dynamic.chronologies'), new ChronologyResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.value.dynamic.achievments'), new AchievementResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.value.dynamic.countries'), new CountryResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.value.dynamic.todays'), new TodayResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.rnd.title'), [
				MenuItem::make(__('moonshine::section.static'), new RndPageResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.news.title'), [
				MenuItem::make(__('moonshine::section.static'), new NewsPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.news.dynamic.news'), new NewsResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.news.dynamic.press'), new PressResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.gallery.title'), [
				MenuItem::make(__('moonshine::section.static'), new GalleryPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.gallery.dynamic.gallery_sites'), new GallerySiteResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.gallery.dynamic.galleries'), new GalleryResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),

			MenuGroup::make(__('moonshine::section.legal.title'), [
				MenuItem::make(__('moonshine::section.static'), new LegalPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.legal.dynamic.legalsites'), new LegalSiteResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.legal.dynamic.legals'), new LegalResource())
					->icon('app'),

			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.sites.title'), [
				MenuItem::make(__('moonshine::section.static'), new SitesPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.sites.dynamic.sites'), new SiteResource())
					->icon('app'),

			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.liquidplant.title'), [
				MenuItem::make(__('moonshine::section.static'), new LiquidplantPageResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.solidplant.title'), [
				MenuItem::make(__('moonshine::section.static'), new SolidplantPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.solidplant.dynamic.solidplant_systems'), new SolidplantSystemResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make('Завод МФТ', [
				MenuItem::make(__('moonshine::section.static'), new SoftFormPlantPageResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.biotech.title'), [
				MenuItem::make(__('moonshine::section.static'), new BiotechPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.biotech.dynamic.biotech_equipments'), new BiotechEquipmentResource())
					->icon('app'),

			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.supplement.title'), [
				MenuItem::make(__('moonshine::section.static'), new SupplementPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.supplement.dynamic.supplement_forms'), new SupplementFormResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.technology.title'), [
				MenuItem::make(__('moonshine::section.static'), new TechnologyPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.technology.dynamic.technologies'), new TechnologyResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.equipment.title'), [
				MenuItem::make(__('moonshine::section.static'), new EquipmentPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.equipment.dynamic.preparations'), new EquipmentPreparationResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.equipment.dynamic.equipments'), new EquipmentResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.form.title'), [
				MenuItem::make(__('moonshine::section.static'), new FormPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.form.dynamic.forms'), new FormResource())
					->icon('app'),

			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.product.title'), [
				MenuItem::make(__('moonshine::section.static'), new ProductPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.product.dynamic.products'), new ProductResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.product.dynamic.trades'), new TradeResource())
					->icon('app'),


			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.market.title'), [
				MenuItem::make(__('moonshine::section.static'), new MarketPageResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.certificate.title'), [
				MenuItem::make(__('moonshine::section.static'), new CerfificatePageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.certificate.dynamic.certificates'), new CertificateResource())
					->icon('app'),

			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.contractual.title'), [
				MenuItem::make(__('moonshine::section.static'), new ContractualPageResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.tender.title'), [
				MenuItem::make(__('moonshine::section.static'), new TenderPageResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.provider.title'), [
				MenuItem::make(__('moonshine::section.static'), new ProviderPageResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.vacancy.title'), [
				MenuItem::make(__('moonshine::section.static'), new VacancyPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.vacancy.dynamic.vacancies'), new VacancyResource())
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.internship.title'), [
				MenuItem::make(__('moonshine::section.static'), new InternshipPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.internship.dynamic.labinternship'), new LabinternshipPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.internship.dynamic.labdirections'), new LabdirectionResource())
					->icon('app'),

			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.club.title'), [
				MenuItem::make(__('moonshine::section.static'), new ClubPageResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.club.dynamic.arrangements'), new ArrangementResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.club.dynamic.premises'), new PremiseResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuGroup::make(__('moonshine::section.contact.title'), [
				MenuItem::make(__('moonshine::section.contact.dynamic.contact'), new ContactResource())
					->icon('app'),
				MenuItem::make(__('moonshine::section.contact.dynamic.locations'), new LocationResource())
					->icon('app'),
			])->canSee(
				fn () =>
				in_array(auth('moonshine')->user()->moonshine_user_role_id, $this->adminIds)
			),
			MenuItem::make(__('moonshine::section.vacancy.dynamic.vacancies'), new VacancyResource())->canSee(
				fn () =>
				auth('moonshine')->user()->moonshine_user_role_id === 3
			)->icon('app')
		]);
	}
}
