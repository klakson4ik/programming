<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Partners;

use MoonShine\Decorations\Block;
use MoonShine\Fields\Url;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Metrics\ValueMetric;

use MoonShine\Decorations\Grid;

class PartnersResource extends BaseResource
{
	protected string $model = Partners::class;

	protected string $title = 'Партнёры';

	private string $storageDir = 'partners';

	protected array $imagesFieldsToClear = [
		'img',
	];

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
				Image::make('Иконка', 'img')
					->dir($this->storageDir)
					->removable()
					->allowedExtensions(['svg', 'png', 'jpg', 'jpeg', 'webp']),
				Url::make('Ссылка', 'url')->blank(),
				Text::make('Текст при наведении', 'title')->hideOnIndex(),
				Text::make('Альтернатива для картинки', 'alt'),
			]),
		];
	}

	public function metrics(): array
	{
		return [
			Grid::make([
				ValueMetric::make('Количество активных')
					->value(Partners::where('active', true)->count())
					->columnSpan(6),

				ValueMetric::make('Общее количество')
					->value(Partners::count())
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
