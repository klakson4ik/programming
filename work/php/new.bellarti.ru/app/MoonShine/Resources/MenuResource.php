<?php

namespace App\MoonShine\Resources;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Switcher;

class MenuResource extends BaseResource
{
	protected string $model = Menu::class;

	protected string $title = 'Меню';

	public function fields(): array
	{
		return [
			Block::make([
				Switcher::make('Активен', 'active')
					->default(1)
					->sortable(),
				Switcher::make('Показывать в топ меню', 'show_top')
					->default(1)
					->sortable(),
				Switcher::make('Показывать в нижнем меню', 'show_bottom')
					->default(0)
					->sortable(),
				Number::make('Сортировка', 'sort')
					->min(0)
					->default(500)
					->sortable(),
				Select::make('Родитель', 'parent_id')
					->options($this->getParent())
					->sortable(),
				Text::make('Название', 'name'),
				Slug::make('Код для url', 'code')
					->from('name')
					->hideOnIndex(),
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

	public function filters(): array
	{
		return [
			Select::make('Родитель', 'parent_id')
				->options($this->getParent())
				->sortable(),
			Switcher::make('Активный', 'active')
		];
	}

	private function getParent()
	{
		$items = $this->getModel()->all();
		$array = ['0' => 'Главный пункт'];
		foreach ($items as $item) {
			if ($this->getItem() && $this->getItem()->id == $item->id) {
				continue;
			}
			$array[$item->id] = $item->name;
		}
		return $array;
	}
}
