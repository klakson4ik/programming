<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Clinic;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Select;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Textarea;

class ClinicResource extends BaseResource
{
	protected string $model = Clinic::class;

	protected string $title = 'Клиники';

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
				Select::make('Страница', 'page')
					->options([
						'contacts' => 'Контакты',
						'patient' => 'Пациентам'
					])->default('contacts')
					->sortable(),
				Text::make('Название', 'name'),
				Slug::make('Код', 'code')
					->from('name')
					->unique(),
				BelongsTo::make('Город', 'city', 'name', resource: new CityResource()),
				Text::make('Координаты', 'coords')
					->hideOnIndex(),
				Text::make('Email', 'mail')
					->hideOnIndex(),
				Text::make('Телефон', 'phone')
					->hideOnIndex(),
				Text::make('Адрес', 'address')
					->hideOnIndex(),
				Textarea::make('Описание', 'description')
					->hideOnIndex(),
			]),
		];
	}

	public function filters(): array
	{
		return [
			Select::make('Название', 'name')
				->options(function () {
					$names = Clinic::select('name', 'name as label')->distinct()->pluck('label', 'name');
					return $names->toArray();
				})->nullable(),
			Switcher::make('Активный', 'active'),
			Select::make('Страница', 'page')->options([
				'contacts' => 'Контакты',
				'patient' => 'Пациентам'
			])->nullable()
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
