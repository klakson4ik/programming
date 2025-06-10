<?php

namespace App\MoonShine\Resources;

use App\Helpers\ImageEditor;
use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Number;
use MoonShine\Fields\Image;
use MoonShine\Filters\BelongsToFilter;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;



class GalleryResource extends Resource
{
    public static string $model = 'App\Models\Gallery';

    public static string $title = 'Изображение галереи';

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
                Image::make(__('moonshine::form.field.img'), 'img')
                    ->dir('/images/galleries')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                    ->hint(__('moonshine::form.img.format') . ': 1140x600.')
                    ->hideOnIndex()
                    ->removable(),
                BelongsTo::make('Площадка галереи', 'gallerySite', 'title')
                    ->searchable()
                    ->nullable()
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
            SwitchBooleanFilter::make(__('moonshine::form.field.active'), 'active'),
            BelongsToFilter::make('Площадка галереи', 'gallerySite', 'title')
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
