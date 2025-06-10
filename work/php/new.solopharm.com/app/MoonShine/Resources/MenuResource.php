<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;

class MenuResource extends Resource
{
    public static string $model = 'App\Models\Menu';

    public static string $title = 'Меню';

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
                Select::make('Родитель', 'parent_id')
                    ->options($this->getParent())
                    ->sortable(),
                SwitchBoolean::make('Генерировать дочерние ссылки от предыдущего родителя', 'not_show_childs'),
                Text::make(__('moonshine::form.field.name'), 'name')
                    ->sortable(),
                Text::make(__('moonshine::form.field.url'), 'url')
                    ->sortable()
                    ->nullable(),
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['name', 'url'];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('moonshine::form.field.lang'), 'lang')
                ->options([
                    'ru' => __('moonshine::lang.ru'),
                    'en' => __('moonshine::lang.en')
                ])->nullable(),
            SelectFilter::make('Родитель', 'parent_id')
                ->options([
                    '0' => 'Главный пункт',
                ])->nullable(),
            SwitchBooleanFilter::make(__('moonshine::form.field.active'), 'active')
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
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
