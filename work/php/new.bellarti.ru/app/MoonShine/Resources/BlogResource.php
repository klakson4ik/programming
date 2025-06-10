<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use App\Models\Blog;

use MoonShine\Decorations\Block;
use MoonShine\Fields\Date;
use MoonShine\Fields\ID;
use MoonShine\Fields\Json;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;
use MoonShine\Fields\TinyMce;

use MoonShine\Metrics\ValueMetric;

use MoonShine\Decorations\Grid;


class BlogResource extends BaseResource
{
	protected string $model = Blog::class;

	protected string $title = 'Блог';

	private string $storageDir = 'blog';

	protected array $imagesFieldsToClear = [
		'img',
		'json_img'
	];

	public function fields(): array
	{
		return [
			Block::make([
				ID::make()
					->sortable(),
				Switcher::make('Активен', 'active')
					->default(1)
					->sortable(),
				Number::make('Сортировка', 'sort')
					->min(0)
					->default(500)
					->sortable(),
				Image::make('Фото', 'img')
					->dir($this->storageDir)
					->hideOnIndex()
					->allowedExtensions(['png', 'webp', 'jpeg', 'jpg']),
				Json::make('Файлы', 'json_img')
					->fields([
						Image::make('Значение', 'value')
							->dir($this->storageDir)
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
					->unique(),
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
					->value(Blog::where('active', true)->count())
					->columnSpan(6),

				ValueMetric::make('Общее количество')
					->value(Blog::count())
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
