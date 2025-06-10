<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Publications;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Fields\File;

class PublicationsResource extends BaseResource
{
	protected string $model = Publications::class;

	private string $storageDir = 'publications';

	protected string $title = 'Публикации';

	protected array $imagesFieldsToClear = [
		'image',
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
				Image::make('Фото', 'image')
					->dir($this->storageDir)
					->removable()
					->hideOnIndex()
					->allowedExtensions(['png', 'jpg', 'jpeg', 'webp']),
				Text::make('ФИО', 'name')->required(),
				Text::make('Специальность', 'speciality')
					->required()
					->hideOnIndex(),
				Text::make('Название публикации', 'title')->required(),
				Text::make('Название файла', 'name_link')
					->required()
					->hideOnIndex(),
				File::make('Файл', 'file')
					->hideOnIndex()
					->dir($this->storageDir),
			]),
		];
	}

	public function rules(Model $item): array
	{
		return [];
	}
}
