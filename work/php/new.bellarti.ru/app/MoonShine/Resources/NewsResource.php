<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
use App\Models\News;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Date;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Json;
use MoonShine\Fields\TinyMce;

use MoonShine\Metrics\ValueMetric;

use MoonShine\Decorations\Grid;

class NewsResource extends BaseResource
{
	protected string $model = News::class;

	protected string $title = 'Новости';

	private string $storageDir = 'news';

	protected array $imagesFieldsToClear = [
		'img',
	];

	public function fields(): array
	{
		return [
			Block::make([
				ID::make()->sortable(),
				Switcher::make('Активен', 'active')
					->default(1),
				Number::make('Сортировка', 'sort')
					->min(0)
					->default(500)
					->sortable(),
				Image::make('Изображение', 'img')
					->dir($this->storageDir)
					->hideOnIndex()
					->allowedExtensions(['png', 'webp', 'jpeg', 'jpg'])
					->removable(),
				Json::make('Файлы', 'json_img')
					->fields([
						Image::make('Значение', 'value')
							->dir($this->storageDir)
							->removable()
							->hideOnIndex()
							->allowedExtensions(['png', 'webp', 'jpeg', 'jpg']),
					])
					->hideOnIndex()
					->removable(),
				Text::make('Заголовок', 'title'),
				TinyMce::make('Описание', 'description')
					->hideOnIndex(),
				Slug::make('Код для url', 'code')
					->from('title')
					->unique()
					->hideOnIndex(),
				Text::make('Мета title', 'meta_title')
					->hideOnIndex(),
				Text::make('Мета description', 'meta_description')
					->hideOnIndex(),
				Text::make('Мета keywords', 'meta_keywords')
					->hideOnIndex(),
				Date::make('Дата', 'date')
					->sortable()
					->format('d.m.Y'),
			]),
		];
	}

	public function metrics(): array
	{
		return [
			Grid::make([
				ValueMetric::make('Количество активных')
					->value(News::where('active', true)->count())
					->columnSpan(6),

				ValueMetric::make('Общее количество')
					->value(News::count())
					->columnSpan(6)
			]),
		];
	}


	/**
	 * @param Blog $item
	 *
	 * @return array<string, string[]|string>
	 * @see https://laravel.com/docs/validation#available-validation-rules
	 */
	public function rules(Model $item): array
	{
		return [];
	}
}
