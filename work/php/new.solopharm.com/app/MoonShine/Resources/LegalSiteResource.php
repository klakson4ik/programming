<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Number;
use MoonShine\Fields\Textarea;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;



class LegalSiteResource extends Resource
{
    public static string $model = 'App\Models\LegalSite';

    public static string $title = 'Площадки';

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
                Textarea::make(__('moonshine::form.field.title'), 'title')
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
                ]),

            SwitchBooleanFilter::make(__('moonshine::form.field.active'), 'active')
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
