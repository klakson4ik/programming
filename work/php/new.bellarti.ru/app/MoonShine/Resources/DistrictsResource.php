<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\Relationships\BelongsTo;
use App\Models\Districts;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;

class DistrictsResource extends BaseResource
{
	protected string $model = Districts::class;

	protected string $title = 'Регион';

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
				Text::make('Название', 'title')->required(),
				BelongsTo::make('Принадлежит', 'person', 'name', resource: new PeopleResource())
			]),
		];
	}

	public function filters(): array
	{
		return [
			BelongsTo::make('Принадлежит', 'person', 'name', resource: new PeopleResource()),
			Switcher::make('Активный', 'active')
		];
	}

	/**
	 * @return array<string, string[]|string>
	 * @see https://laravel.com/docs/validation#available-validation-rules
	 */
	public function rules(Model $item): array
	{
		return [];
	}
}
