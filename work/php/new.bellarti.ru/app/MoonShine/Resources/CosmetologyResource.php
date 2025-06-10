<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cosmetology;
use MoonShine\Fields\Url;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Date;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;
use MoonShine\Metrics\ValueMetric;

use MoonShine\Decorations\Grid;

class CosmetologyResource extends BaseResource
{
	protected string $model = Cosmetology::class;

	protected string $title = 'События обучения';

	private string $storageDir = 'news';

	protected array $imagesFieldsToClear = [
		'img',
		'full_img'
	];

	public function fields(): array
	{
		return [
			Block::make([
				ID::make()
				->sortable(),
				Switcher::make('Активен', 'active')
					->default('1')
					->sortable(),
				Number::make('Сортировка', 'sort')
					->min(0)
					->default(500)
					->sortable(),
				Text::make('Заголовок', 'title'),
				Text::make('Время', 'time')
					->hideOnIndex(),
				Image::make('Изображение', 'img')
					->dir($this->storageDir)
					->hideOnIndex()
					->allowedExtensions(['png', 'webp', 'jpeg', 'jpg'])
					->removable(),
				Image::make('Полное изображение', 'full_img')
					->dir($this->storageDir)
					->hideOnIndex()
					->allowedExtensions(['png', 'webp', 'jpeg', 'jpg'])
					->removable(),
				Date::make('Дата', 'date')
					->sortable()
					->format('d-m-Y'),
				TinyMce::make('Описание', 'description')
					->hideOnIndex(),
				Slug::make('Код для url', 'code')
					->from('title')
					->hideOnIndex()
					->unique(),
				Text::make('Мета title', 'meta_title')
					->hideOnIndex(),
				Text::make('Мета description', 'meta_description')
					->hideOnIndex(),
				Text::make('Мета keywords', 'meta_keywords')
					->hideOnIndex(),
				BelongsTo::make('Город', 'city', 'name')
				->hideOnIndex(),
				Url::make('Ссылка на регистрацию', 'link')
				->blank(),
			]),
		];
	}

	public function metrics(): array
	{
		return [
			Grid::make([
				ValueMetric::make('Количество активных')
					->value(Cosmetology::where('active', true)->count())
					->columnSpan(6),

				ValueMetric::make('Общее количество')
					->value(Cosmetology::count())
					->columnSpan(6)
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
