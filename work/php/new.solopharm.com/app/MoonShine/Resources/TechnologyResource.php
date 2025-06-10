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
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Textarea;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;



class TechnologyResource extends Resource
{
    public static string $model = 'App\Models\Technology';

    public static string $title = 'Технологии';

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
                Text::make(__('moonshine::form.field.title'), 'title')->hideOnIndex(),
                Text::make('Короткое название', 'short_title')->required(),
                Textarea::make(__('moonshine::form.field.text'), 'text')
                    ->hideOnIndex(),
                Image::make(__('moonshine::form.field.img'), 'img')
                    ->dir('/images/technologies')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                    ->hint(__('moonshine::form.img.format') . ': 500x500.')
                    ->hideOnIndex()
                    ->removable(),
                Image::make(__('moonshine::form.field.svg'), 'svg')
                    ->dir('/images/technologies')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                    ->hint(__('moonshine::form.img.format') . ': 95x58.')
                    ->hideOnIndex()
                    ->removable(),
                Text::make(__('moonshine::form.field.youtube'), 'youtube')
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
        ImageEditor::resizeInAdmin(500, 500);
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(500, 500);
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete([$item->img, $item->svg]);
    }
}
