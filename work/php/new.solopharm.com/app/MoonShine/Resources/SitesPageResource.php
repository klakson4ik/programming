<?php

namespace App\MoonShine\Resources;

use App\Helpers\ImageEditor;
use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\Select;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Filters\SelectFilter;



class SitesPageResource extends Resource
{
	public static string $model = 'App\Models\Pages\SitesPage';

	public static string $title = 'Производственные площадки';

	public function fields(): array
	{
		return [
			Block::make('form-container', [
				Tabs::make([
					Tab::make(__('moonshine::form.tab.main'), [
						Select::make(__('moonshine::form.field.lang'), 'lang')
							->options([
								'ru' => __('moonshine::lang.ru'),
								'en' => __('moonshine::lang.en')
							]),
						Image::make(__('moonshine::form.field.img'), 'img')
							->dir('/images/pages')
							->disk('public')
							->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
							->hint(__('moonshine::form.img.format') . ': 1140x500.')
							->hideOnIndex()
							->removable(),
						Heading::make(__('moonshine::form.head.seo')),
						Text::make(__('moonshine::form.field.seo.title'), 'seo_title')->hideOnIndex(),
						Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
						Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex(),

					]),
					Tab::make('Стандарт качества', [
						Textarea::make(__('moonshine::form.field.title'), 'block_1_title')
							->hideOnIndex(),
						Textarea::make(__('moonshine::form.field.desc'), 'block_1_desc')
							->hideOnIndex(),
						Image::make(__('moonshine::form.field.img'), 'block_1_img')
							->dir('/images/pages')
							->disk('public')
							->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
							->hint(__('moonshine::form.img.format') . ': 357x287.')
							->hideOnIndex()
							->removable(),
						Textarea::make(__('moonshine::form.field.subtitle'), 'block_1_subtitle')
							->hideOnIndex(),
						Json::make(__('moonshine::form.field.data'), 'block_1_data')
							->fields([
								Textarea::make(__('moonshine::form.field.title'), 'title'),
								Textarea::make(__('moonshine::form.field.text'), 'value')
							])->removable()
							->nullable()
							->hideOnIndex(),
					]),
					Tab::make('Solopharm сегодня', [
						Textarea::make(__('moonshine::form.field.title'), 'block_2_title')
							->hideOnIndex(),
						Json::make(__('moonshine::form.field.data'), 'block_2_data')
							->fields([
								Textarea::make(__('moonshine::form.field.text'), 'value')
							])->removable()
							->nullable()
							->hideOnIndex(),
						Textarea::make(__('moonshine::form.field.desc'), 'block_2_desc')
							->hideOnIndex(),
						Image::make(__('moonshine::form.field.img'), 'block_2_img')
							->dir('/images/pages')
							->disk('public')
							->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
							->hint(__('moonshine::form.img.format') . ': 487x185.')
							->hideOnIndex()
							->removable(),
					]),
					Tab::make('Контроль качества', [
						Textarea::make(__('moonshine::form.field.title'), 'control_quality_title')
							->hideOnIndex(),
						Image::make(__('moonshine::form.field.icon'), 'control_quality_title_svg')
							->dir('/images/pages')
							->disk('public')
							->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
							->hideOnIndex()
							->removable(),
						Textarea::make(__('moonshine::form.field.subtitle'), 'control_quality_subtitle')
							->hideOnIndex(),
						Json::make(__('moonshine::form.field.data'), 'control_quality_data')
							->fields([
								Textarea::make(__('moonshine::form.field.text'), 'value')
							])->removable()
							->nullable()
							->hideOnIndex(),
						Image::make(__('moonshine::form.field.img'), 'control_quality_img')
							->dir('/images/pages')
							->disk('public')
							->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
							->hint(__('moonshine::form.img.format') . ': 487x185.')
							->hideOnIndex()
							->removable(),
					]),
					Tab::make('Площадки', [
						Textarea::make(__('moonshine::form.field.title'), 'block_3_title')
							->hideOnIndex(),
					])
				]),

			]),
		];
	}

	public function rules(Model $item): array
	{
		return [];
	}

	public function search(): array
	{
		return ['title'];
	}

	public function filters(): array
	{
		return [
			SelectFilter::make(__('moonshine::form.field.lang'), 'lang')
				->options([
					'ru' => __('moonshine::lang.ru'),
					'en' => __('moonshine::lang.en')
				])->nullable(),
		];
	}

	public function actions(): array
	{
		return [
			FiltersAction::make(trans('moonshine::ui.filters')),
		];
	}

	protected function beforeCreating(Model $item)
	{
		ImageEditor::resizeInAdmin(1140, 500);
		ImageEditor::resizeInAdmin(357, 287, 'block_1_img');
		ImageEditor::resizeInAdmin(487, 185, 'block_2_img');
	}

	protected function beforeUpdating(Model $item)
	{
		ImageEditor::resizeInAdmin(1140, 500);
		ImageEditor::resizeInAdmin(357, 287, 'block_1_img');
		ImageEditor::resizeInAdmin(487, 185, 'block_2_img');
	}

	protected function afterDeleted(Model $item)
	{
		StorageHelper::delete([$item->img, $item->block_1_img, $item->block_3_img]);
	}
}
