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
use MoonShine\Fields\Number;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Textarea;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;



class EquipmentPreparationResource extends Resource
{
    public static string $model = 'App\Models\EquipmentPreparation';

    public static string $title = 'Подготовки';

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
                textArea::make(__('moonshine::form.field.title'), 'title'),
                Image::make(__('moonshine::form.field.img'), 'img')
                    ->dir('/images/equipment_preparations')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                    ->hint(__('moonshine::form.img.format') . ': 1140x550.')
                    ->hideOnIndex()
                    ->removable(),
                Json::make(__('moonshine::form.field.data'), 'data')
                    ->fields([
                        Textarea::make(__('moonshine::form.field.title'), 'title'),
                        Textarea::make(__('moonshine::form.field.text'), 'value')
                    ])->removable()
                    ->nullable()
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
        return ['title'];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('moonshine::form.field.lang'), 'lang')
                ->options([
                    'ru' => __('moonshine::lang.ru'),
                    'en' => __('moonshine::lang.en')
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

    protected function beforeCreating(Model $item)
    {
        ImageEditor::resizeInAdmin(1140, 550);
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(1140, 550);
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->img);
    }
}
