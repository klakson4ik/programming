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
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Text;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;



class GallerySiteResource extends Resource
{
    public static string $model = 'App\Models\GallerySite';

    public static string $title = 'Площадка';

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
                SwitchBoolean::make('Показывать на разводящей', 'show_in_sites')
                    ->sortable()
                    ->hideOnIndex(),
                Number::make(__('moonshine::form.field.sort'), 'sort')
                    ->min(0)
                    ->default(500)
                    ->sortable(),
                Image::make(__('moonshine::form.field.img'), 'img')
                    ->dir('/images/gallery_sites')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                    ->hint(__('moonshine::form.img.format') . ': 360x500.')
                    ->hideOnIndex()
                    ->removable(),
                TextArea::make(__('moonshine::form.field.title'), 'title'),
                Text::make(__('moonshine::form.field.link'), 'link')
                    ->hideOnIndex(),
                Text::make(__('moonshine::form.field.btn'), 'btn')
                    ->hideOnIndex(),
                Text::make(__('moonshine::form.field.action'), 'action')
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
        ImageEditor::resizeInAdmin(360, 500);
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(360, 500);
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->img);
    }
}
