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
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Textarea;

class AchievementResource extends Resource
{
    public static string $model = 'App\Models\Achievement';

    public static string $title = 'Achievement';

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
                Select::make(__('moonshine::form.field.block'), 'page')
                    ->options([
                        1 => '1 блок',
                        2 => '2 блок'
                    ])
                    ->sortable(),
                Textarea::make(__('moonshine::form.field.text'), 'text')->hideOnIndex(),
                Image::make(__('moonshine::form.field.img'), 'img')
                    ->dir('/images/achievment')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
                    ->hint('jpg, png, webp: 546x530')
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
        ImageEditor::resizeInAdmin(546, 530);
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(546, 530);
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->img);
    }
}
