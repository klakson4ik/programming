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
use MoonShine\Fields\File;
use MoonShine\Filters\SelectFilter;



class ProductPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\ProductPage';

    public static string $title = 'Препараты';

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
                        Textarea::make(__('moonshine::form.field.title'), 'title')
                            ->hideOnIndex(),
                        Heading::make(__('moonshine::form.head.seo')),
                        Text::make(__('moonshine::form.field.seo.title'), 'seo_title')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex(),
                        Text::make(('Название первого каталога'), 'file_1_name')->hideOnIndex(),
                        File::make('Первый каталог', 'file_1')
                            ->dir('/files/product-page')
                            ->disk('public')
                            ->allowedExtensions(['pdf'])
                            ->hint(__('moonshine::form.file.format'))
                            ->keepOriginalFileName()
                            ->removable()
                            ->nullable()
                            ->hideOnIndex(),
                        Text::make(('Название второго каталога'), 'file_2_name')->hideOnIndex(),
                        File::make('Второй каталог', 'file_2')
                            ->dir('/files/product-page')
                            ->disk('public')
                            ->allowedExtensions(['pdf'])
                            ->hint(__('moonshine::form.file.format'))
                            ->keepOriginalFileName()
                            ->removable()
                            ->nullable()
                            ->hideOnIndex(),
                    ]),
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
