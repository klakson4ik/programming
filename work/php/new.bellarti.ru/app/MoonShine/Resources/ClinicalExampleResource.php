<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\ClinicalExamples;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Fields\Image;
use MoonShine\Fields\TinyMce;

class ClinicalExampleResource extends BaseResource
{
	protected string $model = ClinicalExamples::class;

	protected string $title = 'Клинические примеры';

	protected array $imagesFieldsToClear = [
		'img_before',
		'img_after'
	];

	private string $storageDir = 'clinical-example';

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
				Image::make('Изображение до', 'img_before')
					->allowedExtensions(['png', 'jpeg', 'jpg', 'webp'])
					->removable()
					->hideOnIndex()
					->dir($this->storageDir),
				Image::make('Изображение после', 'img_after')
					->allowedExtensions(['png', 'jpeg', 'jpg', 'webp'])
					->removable()
					->hideOnIndex()
					->dir($this->storageDir),
				Text::make('Название', 'title')->required(),
				Text::make('ФИО', 'name')->required(),
				Text::make('Город', 'town')->required()
					->hideOnIndex(),
				TinyMce::make('Описание', 'description')
					->hideOnIndex(),
			]),
		];
	}

	/**
	 * @param ClinicalExamples $item
	 *
	 * @return array<string, string[]|string>
	 * @see https://laravel.com/docs/validation#available-validation-rules
	 */
	public function rules(Model $item): array
	{
		return [];
	}
}
