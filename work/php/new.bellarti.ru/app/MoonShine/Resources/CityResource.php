<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Fields\Slug;

class CityResource extends BaseResource
{
	protected string $model = City::class;

	protected string $title = 'Города';

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
				Text::make('Название', 'name'),
				Slug::make('Код', 'code')
					->from('name')
					->unique(),
				Text::make('Координаты', 'coords')
					->hideOnIndex(),
				Number::make('Зум', 'zoom')
					->hideOnIndex()
					->max(20)
					->min(8)
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
