<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Select;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Text;
use MoonShine\Filters\SelectFilter;



class LegalPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\LegalPage';

    public static string $title = 'Документы';

    public function fields(): array
    {
        return [
            Block::make('', [
                Select::make(__('moonshine::form.field.lang'), 'lang')
                    ->options([
                        'ru' => __('moonshine::lang.ru'),
                        'en' => __('moonshine::lang.en')
                    ]),
                Heading::make(__('moonshine::form.head.seo')),
                Text::make(__('moonshine::form.field.seo.title'), 'seo_title')->hideOnIndex(),
                Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
                Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex(),
                Text::make(__('moonshine::form.field.title'), 'title')
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
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
