<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\People;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;

class PeopleResource extends BaseResource
{
	protected string $model = People::class;

	protected string $title = 'Региональные представители';

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
				HasMany::make('Регионы', 'districts', 'title', resource: new DistrictsResource())->hideOnIndex(),
				Text::make('Должность', 'post')->required(),
				Text::make('Имя', 'name')->required(),
				Text::make('Номер', 'number')
					->required()
					->hideOnIndex(),
				Text::make('Почта', 'email')
					->required()
					->hideOnIndex(),
			]),
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
