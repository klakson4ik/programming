<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\Select;
use MoonShine\Fields\TinyMce;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Text;
use MoonShine\Filters\SelectFilter;



class EquipmentPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\EquipmentPage';

    public static string $title = 'Оборудование';

    public function fields(): array
    {
        return [
            Block::make('form-container', [
                Tabs::make([
                    Tab::make(__('moonshine::form.tab.main'), [
                        Select::make(__('moonshine::form.field.lang'), 'lang')
                            ->options([
                                'ru' => __('moonshine::lang.ru'),
                                'en' => __('moonshine::lang.en')
                            ]),
                        TextArea::make(__('moonshine::form.field.title'), 'title')
                            ->hideOnIndex(),
                        Heading::make(__('moonshine::form.head.seo')),
                        Text::make(__('moonshine::form.field.seo.title'), 'seo_title')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex()
                    ]),
                    Tab::make('Описание', [
                        TinyMce::make(__('moonshine::form.field.desc'), 'desc')
                            ->hideOnIndex(),
                        TinyMce::make(__('moonshine::form.field.text'), 'text')
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Описание под картинкой', [
                        textArea::make(__('moonshine::form.field.title'), 'block_1_title')
                            ->hideOnIndex(),
                        textArea::make(__('moonshine::form.field.text'), 'block_1_text')
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Оборудование', [
                        Textarea::make('Текст 1', 'block_2_text_1')
                            ->hideOnIndex(),
                        Textarea::make('Текст 2', 'block_2_text_2')
                            ->hideOnIndex(),
                        Textarea::make('Текст 3', 'block_2_text_3')
                            ->hideOnIndex(),
                    ])
                ]),

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
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
