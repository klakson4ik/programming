<?php

namespace App\MoonShine\Resources;

use App\Helpers\ImageEditor;
use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Date;
use MoonShine\Fields\Number;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\TinyMce;

class TodayResource extends Resource
{
    public static string $model = 'App\Models\Today';

    public static string $title = 'Today';

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
                Text::make(__('moonshine::form.field.title'), 'title')
                    ->hideOnIndex(),
                Image::make(__('moonshine::form.field.img'), 'img')
                    ->dir('/images/today')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
                    ->hint('jpg, png, webp: 1140x600')
                    ->removable(),
                TextArea::make('Текст', 'text')->hideOnIndex(),
                Text::make('Заголовок на слайде', 'slide_title')
                    ->hideOnIndex(),
                TinyMce::make('Текст на слайде', 'slide_text')
                    ->hideOnIndex(),
            ]),
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
        ImageEditor::resizeInAdmin(1140, 600);
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(1140, 600);
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->img);
    }
}
