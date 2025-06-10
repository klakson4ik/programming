<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\MoonShine\Resources\PublicationsResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;
use MoonShine\Fields\File;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Number;
use MoonShine\Fields\Json;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\OffersResource;
use App\MoonShine\Resources\VideosResource;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Metrics\ValueMetric;

use MoonShine\Decorations\Grid;

class ProductsResource extends BaseResource
{

	private string $storageDir = 'product';

	protected string $model = Product::class;

	protected string $title = 'Товары';

	protected array $imagesFieldsToClear = [
		'images',
		'image',
		'preview',
	];

	public function fields(): array
	{
		return [
			Block::make([
				ID::make()
					->sortable(),
				Switcher::make('Активен', 'active')
					->default(0)
					->sortable(),
				Number::make('Сортировка', 'sort')
					->min(0)
					->default(500)
					->sortable(),
				HasMany::make('Предложения', 'offers', 'name', resource: new OffersResource())
					->hideOnIndex(),
				Text::make('Название', 'name')
					->required(),
				Text::make('Процедура', 'title'),
				Image::make('Фото', 'images')
					->dir($this->storageDir)
					->removable()
					->allowedExtensions(['png', 'jpg', 'jpeg', 'webp']),
				BelongsToMany::make('Публикации', 'publications', 'title', resource: new PublicationsResource())
					->selectMode()
					->hideOnIndex(),
				BelongsTo::make('Приоритетное предложение', 'priorityOffer', 'name', resource: new OffersResource())
					->hideOnIndex()
					->valuesQuery(function ($query) {
						$product = $this->getItem();
						if ($product) {
							return $query->where('product_id', $product->id); // Фильтруем по текущему продукту
						}
						// Если продукта нет, возвращаем пустой запрос
						return $query->whereRaw('1 = 0');
					}),
				TinyMce::make('Описание', 'description')->required()->hideOnIndex(),
				TinyMce::make('Состав', 'structure')->required()->hideOnIndex(),
				TinyMce::make('Показания', 'indications')->hideOnIndex()->required(),
				TinyMce::make('Курс', 'course')->hideOnIndex()->required(),
				Json::make('Техника', 'technologies')
					->fields([
						Text::make('Название', 'title'),
						TinyMce::make('Текст', 'value'),
						File::make('Фото', 'image')
							->dir($this->storageDir)
							->removable()
							->allowedExtensions(['png', 'jpg', 'jpeg', 'webp']),
						Number::make('Сортировка', 'sort')
							->min(0)
							->default(500)
							->sortable(),
						Switcher::make('Активен', 'active')
							->default(1),
					])
					->hideOnIndex()
					->removable(),
				Slug::make('URL')
					->from('name')
					->separator('-')
					->unique()
					->hideOnIndex(),
				Json::make('Файлы', 'file')
					->fields([
						Text::make('Название', 'title'),
						File::make('Значение', 'value')
							->dir($this->storageDir),
						Number::make('Сортировка', 'sort')
							->min(0)
							->default(500)
							->sortable(),
						Switcher::make('Активен', 'active')
							->default(1),
					])
					->hideOnIndex()
					->removable(),
				Text::make('Мета title', 'meta_title')
					->hideOnIndex(),
				Text::make('Мета description', 'meta_description')
					->hideOnIndex(),
				Text::make('Мета keywords', 'meta_keywords')
					->hideOnIndex(),
				BelongsToMany::make('Видео', 'videos', 'name', resource: new VideosResource())
					->selectMode()
					->hideOnIndex(),
			]),
		];
	}


	public function metrics(): array
	{
		return [
			Grid::make([
				ValueMetric::make('Количество активных')
					->value(Product::where('active', true)->count())
					->columnSpan(6),

				ValueMetric::make('Общее количество')
					->value(Product::count())
					->columnSpan(6)
			]),
		];
	}


	public function rules(Model $item): array
	{
		return [];
	}
}
