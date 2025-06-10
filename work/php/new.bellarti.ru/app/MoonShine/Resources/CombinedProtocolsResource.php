<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\CombinedProtocols;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Fields\Text;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Json;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\File;


class CombinedProtocolsResource extends BaseResource
{

	private string $storageDir = 'combined-protocol';

	protected string $model = CombinedProtocols::class;

	protected string $title = 'Сочетанные протоколы';

	/**
	 * @return list<MoonShineComponent|Field>
	 */
	public function fields(): array
	{
		return [
			Block::make([
				ID::make()->sortable(),
				Text::make('Название', 'title')->required(),
				Json::make('Техника', 'technologies')
					->fields([
						Text::make('Название', 'subtitle'),
						TinyMce::make('Описание', 'value'),
						File::make('Фото', 'image')
							->dir($this->storageDir)
							->removable()
							->allowedExtensions(['png', 'jpg', 'jpeg', 'webp']),
					])
					->hideOnIndex()
					->removable(),
			]),
		];
	}
	/**
	 * @param CombinedProtocols $item
	 *
	 * @return array<string, string[]|string>
	 * @see https://laravel.com/docs/validation#available-validation-rules
	 */
	public function rules(Model $item): array
	{
		return [];
	}
}
