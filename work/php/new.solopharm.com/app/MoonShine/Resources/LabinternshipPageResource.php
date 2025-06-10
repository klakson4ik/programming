<?php

namespace App\MoonShine\Resources;

use App\Helpers\ImageEditor;
use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\Select;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Filters\SelectFilter;



class LabinternshipPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\LabinternshipPage';

    public static string $title = 'Стажировка в лаборатории';

    public function fields(): array
    {
        return [
            Block::make('', [
                Tabs::make([
                    Tab::make(__('moonshine::form.tab.main'), [
                        Select::make(__('moonshine::form.field.lang'), 'lang')
                            ->options([
                                'ru' => __('moonshine::lang.ru'),
                                'en' => __('moonshine::lang.en')
                            ]),
                        Image::make(__('moonshine::form.field.img'), 'img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 1140x500.')
                            ->hideOnIndex()
                            ->removable(),
                        Heading::make(__('moonshine::form.head.seo')),
                        Text::make(__('moonshine::form.field.seo.title'), 'seo_title')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex()
                    ]),
                    Tab::make('Стажировка', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_1_title')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'block_1_desc')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.subtitle'), 'block_1_subtitle')
                            ->hideOnIndex(),
                        Json::make(__('moonshine::form.field.data'), 'block_1_data')
                            ->fields([
                                Textarea::make(__('moonshine::form.field.text'), 'value')
                            ])->removable()
                            ->nullable()
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Направления', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_2_title')
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Информация', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_3_title')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'block_3_desc')
                            ->hideOnIndex(),
                        Text::make(__('moonshine::form.field.btn'), 'block_3_btn')
                            ->hideOnIndex(),
                        Text::make(__('moonshine::form.field.action'), 'block_3_action')
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

    protected function beforeCreating(Model $item)
    {
        ImageEditor::resizeInAdmin(1140, 500);
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(1140, 500);
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->img);
    }
}
