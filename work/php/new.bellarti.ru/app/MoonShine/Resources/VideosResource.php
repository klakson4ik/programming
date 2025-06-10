<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Decorations\Block;
use MoonShine\Fields\File;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;

class VideosResource extends BaseResource
{
	protected string $model = Video::class;

	protected string $title = 'Видео';

	protected array $imagesFieldsToClear = [
		'preview'
	];

	private string $storageDir = 'video';

	public function fields(): array
	{
		return [
			Block::make([
				ID::make()->sortable(),
				Text::make('Название', 'name')->required(),
				BelongsToMany::make('Продукты', 'products', 'name', resource: new ProductsResource())
					->selectMode()
					->hideOnIndex(),
				Slug::make('Код', 'code')
					->from('name')
					->unique()
					->hideOnAll(),
				File::make('Видео', 'video')
					->dir($this->storageDir)
					->removable()
					->hideOnIndex()
					->allowedExtensions(['mp4', 'ogv', 'avi', 'webm']),
				Text::make('Видео VK', 'video_vk')
					->hideOnIndex()
					->unescape()
					->sortable(),
				Image::make('Preview', 'preview')
					->dir($this->storageDir)
					->removable()
					->hideOnIndex()
					->allowedExtensions(['png', 'jpg', 'jpeg', 'webp']),
			]),
		];
	}


	public function rules(Model $item): array
	{
		return [];
	}
}
