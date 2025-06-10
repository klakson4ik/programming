<?php

namespace App\MoonShine\Resources;

use App\Helpers\ImageEditor;
use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Slug;

class DirectionResource extends Resource
{
	public static string $model = 'App\Models\Direction';

	public static string $title = 'Direction';

	public function fields(): array
	{
		return [
			Block::make('form-container', [
				Select::make(__('moonshine::form.field.lang'), 'lang')
					->options([
						'ru' => __('moonshine::lang.ru'),
						'en' => __('moonshine::lang.en')
					])
					->sortable(),
				SwitchBoolean::make(__('moonshine::form.field.active'), 'active')
					->sortable(),
				Number::make(__('moonshine::form.field.sort'), 'sort')
					->min(0)
					->default(500)
					->sortable(),
				Text::make(__('moonshine::form.field.name'), 'name')
					->sortable(),
				Slug::make('Url', 'url_slug')->from('name')->separator('-')->unique(),
				Select::make('Родитель', 'parent_id')
					->options($this->getParent())
					->sortable(),
				Image::make(__('moonshine::form.field.img'), 'img')
					->dir('/images/direction')
					->disk('public')
					->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
					->hint('jpg, png, webp: 765x510')
					->hideOnIndex()
					->removable(),
				Image::make(__('moonshine::form.field.icon'), 'svg')
					->dir('/images/direction')
					->disk('public')
					->allowedExtensions(['svg'])
					->hint('svg' . ': 75x75.')
					->hideOnIndex()
					->removable(),

			])
		];
	}

	public function rules(Model $item): array
	{
		return [];
	}

	public function search(): array
	{
		return ['id'];
	}

	public function filters(): array
	{
		return [];
	}

	public function actions(): array
	{
		return [
			FiltersAction::make(trans('moonshine::ui.filters')),
		];
	}

	protected function beforeCreating(Model $item)
	{
		ImageEditor::resizeInAdmin(765, 510);
	}

	protected function beforeUpdating(Model $item)
	{
		ImageEditor::resizeInAdmin(765, 510);
	}

	protected function afterDeleted(Model $item)
	{
		StorageHelper::delete($item->img);
		StorageHelper::delete($item->label);
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
