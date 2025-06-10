<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\Image;
use MoonShine\Fields\Url;
use MoonShine\Filters\BelongsToFilter;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;
use MoonShine\Filters\TextFilter;
use App\Helpers\ImageEditor;
use App\Helpers\StorageHelper;
use App\Services\CostumExportService;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Decorations\Button;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\File;
use MoonShine\Fields\Json;
use MoonShine\Fields\NoInput;
use MoonShine\Fields\Slug;

class TradeResource extends Resource
{
	public static string $model = 'App\Models\Trade';

	public static string $title = 'Торговые предложения';

	public function fields(): array
	{
		return [
			Block::make('', [
				Tabs::make([
					Tab::make(__('moonshine::form.tab.main'), [
						Flex::make('Title/Slug', [
							Button::make(
								'RU',
								url()->current() . '?lang=ru'
							)->icon('clip'),
							Button::make(
								'EN',
								url()->current() . '?lang=en'
							)->icon('clip'),
						]),
						Text::make(__('moonshine::form.field.lang'), 'lang', fn ($item) =>
						isset($_GET['lang']) ? $_GET['lang'] : ($item->lang ?: 'ru'))
							->readonly(),
						SwitchBoolean::make('Отображать предложение на разводящей', 'show_in_list')
							->sortable(),
						SwitchBoolean::make(__('moonshine::form.field.active'), 'active')
							->sortable(),
						SwitchBoolean::make('Можно купить', 'can_buy')
							->sortable()
							->hideOnIndex(),
						SwitchBoolean::make('Главный SKU', 'is_main')
							->sortable()
							->nullable(),
						SwitchBoolean::make('Скоро', 'soon')
							->sortable()
							->hideOnIndex(),
						SwitchBoolean::make('ЖНВЛП', 'vital')
							->sortable()
							->hideOnIndex(),
						Number::make(__('moonshine::form.field.sort'), 'sort')
							->min(0)
							->default(500)
							->sortable(),
						Text::make('Форма выпуска', 'form')->sortable(),
						Slug::make('Url', 'url_slug')->from('form')->separator('-')->unique()->showOnExport()->sortable(),
						BelongsTo::make('Препарат', 'product', 'title')
							->searchable()
							->sortable()
							->nullable()
							->valuesQuery(fn (Builder $query) => $query->where('lang', isset($_GET['lang']) ? $_GET['lang'] : (isset($this->getItem()->lang) ? $this->getItem()->lang : 'ru'))),
						BelongsTo::make('Технология', 'technology', 'title')
							->searchable()
							->sortable()
							->nullable()
							->valuesQuery(fn (Builder $query) => $query->where('lang', isset($_GET['lang']) ? $_GET['lang'] : (isset($this->getItem()->lang) ? $this->getItem()->lang : 'ru'))),
						Image::make(__('moonshine::form.field.img'), 'img')
							->dir('/images/trades')
							->disk('public')
							->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
							->hint(__('moonshine::form.img.format') . ': 711x711.')
							->hideOnIndex()
							->removable(),
						BelongsTo::make('Направление', 'direction', 'name')
							->searchable()
							->nullable()
							->hideOnIndex()
							->valuesQuery(fn (Builder $query) => $query->where('lang', isset($_GET['lang']) ? $_GET['lang'] : (isset($this->getItem()->lang) ? $this->getItem()->lang : 'ru'))),
						TinyMce::make('Показания к применению  / Область применения', 'indications')
							->hideOnIndex(),
						TinyMce::make('Область применения (Будет убрано)', 'scope')
							->hideOnIndex(),
						Textarea::make('Состав / МНН', 'compound')
							->hideOnIndex(),
						Textarea::make('МНН (Будет убрано)', 'MNN')
							->hideOnIndex(),
						Textarea::make('Фармакотерапевтическая группа / Фарм область применения', 'pharm')
							->hideOnIndex(),
						Textarea::make('Фарм область применения (Область применения)', 'scope_pharm')
							->hideOnIndex(),
						File::make('Инструкция', 'instruction')
							->dir('/files/trades')
							->disk('public')
							->allowedExtensions(['pdf'])
							->hint(__('moonshine::form.file.format'))
							->hideOnIndex()
							->removable(),
						Url::make('Ссылка на сайт', 'site')
							->hideOnIndex(),
						Text::make(__('moonshine::form.field.youtube'), 'youtube')
							->hideOnIndex(),
						Url::make('IQ provision', 'IQ_provision')
							->hideOnIndex(),
						SwitchBoolean::make('CE', 'CE')
							->sortable()
							->hideOnIndex(),
						SwitchBoolean::make('Экспорт', 'export')
							->sortable()
							->hideOnIndex(),
						Url::make('Ссылка Wildberries', 'wb_link')
							->hideOnIndex(),
						Url::make('Ссылка Ozon', 'ozon_link')
							->hideOnIndex(),
						Text::make('ID Uteka (разделять запятой, если несколько)', 'uteka_id')
							->hideOnIndex(),
						Json::make('Страны экспорта', 'export_countries')
							->fields([
								Text::make(__('moonshine::form.field.name'), 'value'),
							])->removable()
							->nullable()
							->hideOnIndex(),
					]),
					Tab::make('Связанный препарат', [
						NoInput::make(
							'Препарат',
							'youtube',
							fn (Model $item) => sprintf(
								'<p class="my-5 font-bold text-md text-black dark:text-white">Препарат: %s</p><div>%s</div>',
								$item->title,
								$this->getChunkProductsHtml($item),
							)
						)->fullWidth()
							->hideOnIndex()
							->fieldContainer(false)
					])
				])
			])
		];
	}

	public function rules(Model $item): array
	{
		return [];
	}

	public function search(): array
	{
		return ['form'];
	}

	public function filters(): array
	{
		return [
			SelectFilter::make(__('moonshine::form.field.lang'), 'lang')
				->options([
					'ru' => __('moonshine::lang.ru'),
					'en' => __('moonshine::lang.en')
				])
				->nullable(),
			BelongsToFilter::make('Препараты', 'product', 'title')
				->searchable()
				->nullable(),
		];
	}

	public function actions(): array
	{
		return [
			FiltersAction::make(trans('moonshine::ui.filters')),
			CostumExportService::make('Экспорт')

		];
	}

	protected function beforeCreating(Model $item)
	{
		ImageEditor::resizeInAdmin(711, 711);
	}

	protected function beforeUpdating(Model $item)
	{
		ImageEditor::resizeInAdmin(711, 711);
	}

	protected function afterDeleted(Model $item)
	{
		StorageHelper::delete($item->img);
	}

	protected function getResizeImageColumns(): array
	{
		return ['img'];
	}

	private function getChunkProductsHtml(Model $model)
	{
		$product = $model->product()->get();
		if (isset($product[0])) {
			$html = "<p style='width: fit-content; color: rgb(156 163 175);' class='form_submit_button bg-gradient-to-r from-purple to-pink font-semibold py-2 px-4 rounded mb-4'><a href='/admin/resource/product-resource/" . $product[0]->id . '/edit' . "'>" . $product[0]->title . "</a></p>";
		} else {
			$html = "<p>Пока нет</p>";
		}
		return $html;
	}
}
