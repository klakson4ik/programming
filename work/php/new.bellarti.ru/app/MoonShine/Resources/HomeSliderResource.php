<?php

namespace App\MoonShine\Resources;

use App\Models\HomeSlider;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Image;

class HomeSliderResource extends BaseResource
{
	protected string $model = HomeSlider::class;

	protected string $title = 'Слайдер на главной';

	private string $storageDir = 'slider-home';

	protected array $imagesFieldsToClear = [
		'img',
	];

	public function fields(): array
	{
		return [
			Block::make([
				Switcher::make('Активен', 'active')
					->default(1)
					->sortable(),
				Number::make('Сортировка', 'sort')
					->min(0)
					->default(500)
					->sortable(),
				Text::make('Заголовок', 'title'),
				Text::make('Описание', 'description')
					->hideOnIndex(),
				Image::make('Иконка', 'svg')
					->hideOnIndex()
					->dir($this->storageDir)
					->removable()
					->allowedExtensions(['svg']),
				Image::make('Изоброжение', 'img')
					->hideOnIndex()
					->dir($this->storageDir)
					->allowedExtensions(['png', 'jpeg', 'jpg', 'webp'])
					->removable(),
			])
		];
	}

	public function rules(Model $item): array
	{
		return [];
	}
}
