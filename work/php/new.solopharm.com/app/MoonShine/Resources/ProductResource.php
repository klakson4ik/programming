<?php

namespace App\MoonShine\Resources;

use App\Helpers\ImageEditor;
use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\Image;
use MoonShine\Fields\File;
use MoonShine\Fields\NoInput;
use MoonShine\Fields\Select;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Url;
use MoonShine\Filters\BelongsToFilter;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Decorations\Button;
use MoonShine\Decorations\Flex;
use MoonShine\Fields\Slug;

class ProductResource extends Resource
{
	public static string $model = 'App\Models\Product';

	public static string $title = 'Препараты';

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
						Text::make(__('moonshine::form.field.lang'), 'lang', fn($item) =>
						isset($_GET['lang']) ? $_GET['lang'] : ($item->lang ?: 'ru'))
							->readonly(),
						SwitchBoolean::make(__('moonshine::form.field.active'), 'active')
							->sortable(),
						SwitchBoolean::make('Можно купить', 'can_buy')
							->sortable()
							->hideOnIndex(),
						SwitchBoolean::make('Скоро', 'soon')
							->sortable()
							->hideOnIndex(),
						SwitchBoolean::make('ЖНВЛП', 'vital')
							->sortable()
							->hideOnIndex(),
						SwitchBoolean::make('Исключить из новинок', 'is_exclude_novelty')
							->sortable()
							->hideOnIndex(),
						Block::make('Признаки продукта', [
							SwitchBoolean::make('Безрецептурный', 'otc')
								->hideOnIndex(),
							SwitchBoolean::make('Рецептурный', 'recept')
								->hideOnIndex(),
							SwitchBoolean::make('Экспорт', 'export')
								->hideOnIndex()
						]),
						Select::make('Категория препарата', 'category')
							->sortable()
							->options([
								'dietary_supplements' => 'БАД',
								'medical_device' => 'Медицинское изделие',
								'medicinal_product' => 'Лекарственное средство'
							])
							->default('dietary')
							->hideOnIndex(),
						Number::make(__('moonshine::form.field.sort'), 'sort')
							->min(0)
							->default(500)
							->sortable(),
						Text::make(__('moonshine::form.field.title'), 'title')->sortable(),
						Slug::make('Slug', 'url_slug')->from('title')->separator('-')->unique(),
						Image::make(__('moonshine::form.field.img'), 'img')
							->dir('/images/product')
							->disk('public')
							->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
							->hint('jpg, png, webp: 233x233')
							->hideOnIndex()
							->removable(),
						BelongsToMany::make('Направление', 'direction', 'name')
							->tree('parent_id')
							->searchable()
							->nullable()
							->hideOnIndex()
							->valuesQuery(fn(Builder $query) => $query->where('lang', isset($_GET['lang']) ? $_GET['lang'] : (isset($this->getItem()->lang) ? $this->getItem()->lang : 'ru')))
							->multiple(),
						TinyMce::make('Показания к применению', 'indications')
							->hideOnIndex(),
						TinyMce::make('Область применения (Будет убрано)', 'scope')
							->hideOnIndex(),
						Textarea::make('Состав / МНН', 'compound')
							->hideOnIndex(),
						Textarea::make('МНН (Будет убрано)', 'MNN')
							->hideOnIndex(),
						Textarea::make('Фармакотерапевтическая группа / Фарм область применения', 'pharm')
							->hideOnIndex(),
						Textarea::make('Фарм область применения (Будет убрано)', 'scope_pharm')
							->hideOnIndex(),
						File::make('инструкция', 'instruction')
							->dir('/files/products')
							->disk('public')
							->allowedExtensions(['pdf'])
							->hint(__('moonshine::form.file.format'))
							->hideOnIndex()
							->removable(),
						Url::make('Ссылка на сайт', 'site')
							->hideOnIndex(),
						Select::make('Выбор ресурса для видео', 'tube_type')
							->options([
								'rutube' => 'RuTube',
								'youtube' => 'YouTube'
							]),
						Text::make('RuTube видео', 'rutube')
							->hideOnIndex(),
						Text::make('YouTube видео ', 'youtube')
							->hideOnIndex(),
						Url::make('IQ provision', 'IQ_provision')
							->hideOnIndex(),
						SwitchBoolean::make('CE', 'CE')
							->sortable()
							->hideOnIndex(),
						Url::make('Ссылка Wildberries', 'wb_link')
							->hideOnIndex(),
						Url::make('Ссылка Ozon', 'ozon_link')
							->hideOnIndex(),
						Text::make('ID Uteka (разделять запятой, если несколько)', 'uteka_id')
							->hideOnIndex(),
					]),
					Tab::make('Связанные торговые предложения', [
						NoInput::make(
							'Предложения',
							'youtube',
							fn(Model $item) => sprintf(
								'<p class="my-5 font-bold text-md text-black dark:text-white">Препарат: %s</p><div>%s</div>',
								$item->title,
								$this->getChunkProductsHtml($item),
							)
						)->fullWidth()
							->hideOnIndex()
							->fieldContainer(false)
					])
				])
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

			BelongsToFilter::make('Направление', 'direction', 'name')
				->searchable()
				->nullable(),

			SwitchBooleanFilter::make(__('moonshine::form.field.active'), 'active'),
			SwitchBooleanFilter::make('Можно купить', 'can_buy'),
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
		ImageEditor::resizeInAdmin(233, 233);
	}

	protected function beforeUpdating(Model $item)
	{
		ImageEditor::resizeInAdmin(233, 233);
	}

	protected function afterDeleted(Model $item)
	{
		StorageHelper::delete($item->instruction);
		StorageHelper::delete($item->img);
	}

	protected function getResizeImageColumns(): array
	{
		return ['img'];
	}

	private function getChunkProductsHtml(Model $model)
	{
		$items = $model->trades()->get();
		$html = '';
		foreach ($items as $item) {
			$html .= "<p style='width: fit-content; color: rgb(156 163 175);' class='form_submit_button bg-gradient-to-r from-purple to-pink font-semibold py-2 px-4 rounded mb-4'><a href='/admin/resource/trade-resource/" . $item->id . '/edit' . "'>" . $item->form . "</a></p>";
		}
		return $html;
	}
}
