<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\File;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Filters\BelongsToFilter;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;



class LegalResource extends Resource
{
    public static string $model = 'App\Models\Legal';

    public static string $title = 'Документы';

    public function fields(): array
    {
        return [
            Block::make('', [
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
                BelongsTo::make('Площадка документа', 'legalSite', 'title')
                    ->searchable()
                    ->nullable(),
                File::make(__('moonshine::form.field.file'), 'data')
                    ->dir('/files/legals')
                    ->disk('public')
                    ->allowedExtensions(['pdf'])
                    ->hint(__('moonshine::form.file.format'))
                    ->removable()
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
                ]),

            SwitchBooleanFilter::make(__('moonshine::form.field.active'), 'active'),
            BelongsToFilter::make('Площадка документа', 'legalSite', 'title')
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
