<?php
declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\FAQ;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Components\MoonShineComponent;

class FAQResource extends BaseResource
{
	protected string $model = FAQ::class;

	protected string $title = 'FAQ';

	/**
	 * @return list<MoonShineComponent|Field>
	 */
	public function fields(): array
	{
		return [
			Block::make([
				ID::make()->sortable(),
				Switcher::make('Активен', 'active')
					->default(1),
				Number::make('Сортировка', 'sort')
					->min(0)
					->default(500)
					->sortable(),
				Text::make('Заголовок', 'title')->required(),
				Text::make('Описание', 'description')->required(),
			]),
		];
	}
	/**
	 * @param FAQ $item
	 *
	 * @return array<string, string[]|string>
	 * @see https://laravel.com/docs/validation#available-validation-rules
	 */
	public function rules(Model $item): array
	{
		return [];
	}
}
