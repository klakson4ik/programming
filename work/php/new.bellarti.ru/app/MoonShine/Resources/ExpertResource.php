<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Expert;
use Illuminate\Database\Eloquent\Model;
use App\Models\ExpertsBellarti;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Fields\Image;
use MoonShine\Fields\TinyMce;

class ExpertResource extends BaseResource
{
	protected string $model = Expert::class;

	protected string $title = 'Эксперты';

	private string $storageDir = 'expert';

	protected array $imagesFieldsToClear = [
		'img',
	];

	public function fields(): array
	{
		return [
			Block::make([
				ID::make()->sortable(),
				Switcher::make('Активен', 'active')
					->default('1')
					->sortable(),
				Number::make('Сортировка', 'sort')
					->min(0)
					->default(500)
					->sortable(),
				Image::make('Фото', 'img')
					->dir($this->storageDir)
					->removable()
					->hideOnIndex()
					->allowedExtensions(['png', 'jpeg', 'jpg']),
				Text::make('title для картинки', 'title_for_img')
					->hideOnIndex(),
				Text::make('alt для картинки', 'alt_for_img')
					->hideOnIndex(),
				Text::make('Имя', 'name'),
				TinyMce::make('Описание', 'description')
					->hideOnIndex(),
			]),
		];
	}

	/**
	 * @param ExpertsBellarti $item
	 *
	 * @return array<string, string[]|string>
	 * @see https://laravel.com/docs/validation#available-validation-rules
	 */
	public function rules(Model $item): array
	{
		return [];
	}
}
