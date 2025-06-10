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
use MoonShine\Fields\TinyMce;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Filters\SelectFilter;



class BiotechPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\BiotechPage';

    public static string $title = 'Биотехнологии';

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
                        TinyMce::make(__('moonshine::form.field.title'), 'title')->hideOnIndex(),
                        Heading::make(__('moonshine::form.head.seo')),
                        Text::make(__('moonshine::form.field.seo.title'), 'seo_title')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex()
                    ]),
                    Tab::make('Статистика', [
                        Image::make(__('moonshine::form.field.img'), 'img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 1140x823.')
                            ->hideOnIndex()
                            ->removable(),
                        TinyMce::make(__('moonshine::form.field.title'), 'block_1_title')
                            ->hideOnIndex(),
                        TinyMce::make(__('moonshine::form.field.decs'), 'block_1_decs')
                            ->hideOnIndex(),
                        Json::make(__('moonshine::form.field.data'), 'block_1_data')
                            ->fields([
                                Textarea::make(__('moonshine::form.field.title'), 'title'),
                                Textarea::make(__('moonshine::form.field.text'), 'value')
                            ])->removable()
                            ->nullable()
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Отдел', [
                        TinyMce::make(__('moonshine::form.field.title'), 'block_2_title')
                            ->hideOnIndex(),
                        TextArea::make(__('moonshine::form.field.tab'), 'block_2_tab_1')
                            ->hideOnIndex(),
                        TextArea::make(__('moonshine::form.field.tab'), 'block_2_tab_2')
                            ->hideOnIndex(),
                        Json::make(__('moonshine::form.field.data'), 'block_2_data_1')
                            ->fields([
                                Textarea::make(__('moonshine::form.field.title'), 'title'),

                            ])->removable()
                            ->nullable()
                            ->hideOnIndex(),
                        Json::make(__('moonshine::form.field.data'), 'block_2_data_2')
                            ->fields([
                                Textarea::make(__('moonshine::form.field.title'), 'title'),

                            ])->removable()
                            ->nullable()
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Оборудование', [
                        TinyMce::make(__('moonshine::form.field.title'), 'block_3_title')
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
        // ImageEditor::resizeInAdmin(1140, 823);
    }

    protected function beforeUpdating(Model $item)
    {
        // ImageEditor::resizeInAdmin(1140, 823);
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->img);
    }
}
