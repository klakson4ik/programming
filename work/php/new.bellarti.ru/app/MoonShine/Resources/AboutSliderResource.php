<?php

namespace App\MoonShine\Resources;

use App\Models\AboutSlider;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Image;

class AboutSliderResource extends BaseResource
{
	protected string $model = AboutSlider::class;

	protected string $title = 'Слайдер на странице "О нас"';

	private string $storageDir = 'slider-about';

	protected array $imagesFieldsToClear = [
		'img'
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
					->removable()
					->allowedExtensions(['png', 'jpeg', 'jpg', 'webp']),
			])
		];
	}

	public function rules(Model $item): array
	{
		return [];
	}

	public function search(): array
	{
		return ['name', 'code'];
	}
}
