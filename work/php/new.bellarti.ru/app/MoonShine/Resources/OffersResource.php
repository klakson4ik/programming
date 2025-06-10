<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\File;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Metrics\ValueMetric;

use MoonShine\Decorations\Grid;

class OffersResource extends BaseResource
{
	protected array $imagesFieldsToClear = [
		'images'
	];

	private string $storageDir = 'offer';

	protected string $model = Offer::class;

	protected string $title = 'Торговые предложения';

	public function fields(): array
	{
		return [
			Block::make([
				ID::make()->sortable(),
				Switcher::make('Активен', 'active')
					->default(1)
					->sortable(),
				Number::make('Сортировка', 'sort')
					->min(0)
					->default(500)
					->sortable(),
				BelongsTo::make('Принадлежит к', 'product', 'name', resource: new ProductsResource())
					->required(),
				Text::make('Название', 'name')->required(),
				Image::make('Картинка', 'images')
					->dir($this->storageDir)
					->removable()
					->allowedExtensions(['png', 'jpg', 'jpeg', 'webp']),
				TinyMce::make('Описание', 'description')
					->hideOnIndex(),
				TinyMce::make('Состав', 'structure')
					->hideOnIndex(),
				TinyMce::make('Показания', 'indications')
					->hideOnIndex(),
				TinyMce::make('Курс', 'course')
					->hideOnIndex(),
				File::make('Файл', 'file')->dir($this->storageDir)
					->removable(),
				Text::make('Мета title', 'meta_title')
					->hideOnIndex(),
				Text::make('Мета description', 'meta_description')
					->hideOnIndex(),
				Text::make('Мета keywords', 'meta_keywords')
					->hideOnIndex(),
				Slug::make('URL')
					->from('name')
					->separator('-')
					->unique()
					->hideOnIndex(),
			]),
		];
	}

	public function metrics(): array
	{
		return [
			Grid::make([
				ValueMetric::make('Количество активных')
					->value(Offer::where('active', true)->count())
					->columnSpan(6),

				ValueMetric::make('Общее количество')
					->value(Offer::count())
					->columnSpan(6)
			]),
		];
	}

	public function filters(): array
	{
		return [
			BelongsTo::make('Принадлежит к', 'product', 'name', resource: new ProductsResource()),
			Switcher::make('Активный', 'active')
		];
	}

	/**
	 * @param Offer $item
	 *
	 * @return array<string, string[]|string>
	 * @see https://laravel.com/docs/validation#available-validation-rules
	 */
	public function rules(Model $item): array
	{
		return [];
	}
}
