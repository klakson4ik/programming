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
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Filters\SelectFilter;



class ContractualPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\ContractualPage';

    public static string $title = 'Контрактное производство';

    public function fields(): array
    {
        return [
            Block::make('Контрактное производство', [
                Tabs::make([
                    Tab::make(__('moonshine::form.tab.main'), [
                        Select::make(__('moonshine::form.field.lang'), 'lang')
                            ->options([
                                'ru' => __('moonshine::lang.ru'),
                                'en' => __('moonshine::lang.en')
                            ]),

                        Text::make(__('moonshine::form.field.title'), 'title')
                            ->hideOnIndex(),

                        Heading::make(__('moonshine::form.head.seo')),

                        Text::make(__('moonshine::form.field.seo.title'), 'seo_title')
                            ->hideOnIndex(),

                        Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')
                            ->hideOnIndex(),

                        Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')
                            ->hideOnIndex()
                    ]),

                    Tab::make('Описание', [
                        TinyMce::make(__('moonshine::form.field.desc'), 'desc')
                            ->hideOnIndex(),

                        Image::make(__('moonshine::form.field.img'), 'img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 1140x537.')
                            ->hideOnIndex()
                            ->removable(),
                    ]),

                    Tab::make('Цикл', [
                        Text::make(__('moonshine::form.field.title'), 'block_1_title')
                            ->hideOnIndex(),

                        Image::make(__('moonshine::form.field.img'), 'block_1_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 483x512.')
                            ->hideOnIndex()
                            ->removable(),

                        Json::make(__('moonshine::form.field.data'), 'block_1_data')
                            ->fields([
                                Textarea::make(__('moonshine::form.field.title'), 'title'),
                                Textarea::make(__('moonshine::form.field.text'), 'value')
                            ])
                            ->removable()
                            ->nullable()
                            ->hideOnIndex(),
                    ]),

                    Tab::make('4 линии', [
                        Text::make(__('moonshine::form.field.title'), 'block_2_title')
                            ->hideOnIndex(),

                        TinyMce::make(__('moonshine::form.field.desc'), 'block_2_desc')
                            ->hideOnIndex(),

                        Json::make(__('moonshine::form.field.data'), 'block_2_data')
                            ->fields([
                                Textarea::make(__('moonshine::form.field.title'), 'title'),
                                Textarea::make(__('moonshine::form.field.text'), 'value')
                            ])->removable()
                            ->nullable()
                            ->hideOnIndex(),

                        Image::make(__('moonshine::form.field.img'), 'block_2_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 1140x507.')
                            ->hideOnIndex()
                            ->removable(),
                    ]),

                    Tab::make('2 линии', [
                        Text::make(__('moonshine::form.field.title'), 'block_3_title')
                            ->hideOnIndex(),

                        TinyMce::make(__('moonshine::form.field.desc'), 'block_3_desc')
                            ->hideOnIndex(),

                        Json::make(__('moonshine::form.field.data'), 'block_3_data')
                            ->fields([
                                Textarea::make(__('moonshine::form.field.title'), 'title'),
                                Textarea::make(__('moonshine::form.field.text'), 'value')
                            ])->removable()
                            ->nullable()
                            ->hideOnIndex(),

                        Image::make(__('moonshine::form.field.img'), 'block_3_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 1140x507.')
                            ->hideOnIndex()
                            ->removable(),
                    ]),

                    Tab::make('1 линия', [
                        Text::make(__('moonshine::form.field.title'), 'block_4_title')
                            ->hideOnIndex(),

                        TinyMce::make(__('moonshine::form.field.desc'), 'block_4_desc')
                            ->hideOnIndex(),

                        Image::make(__('moonshine::form.field.img'), 'block_4_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 1140x507.')
                            ->hideOnIndex()
                            ->removable(),

                        Text::make('Текст первой ссылки', 'btn_1')
                            ->hideOnIndex(),

                        File::make('Файл первой ссылки', 'action_1')
                            ->dir('/files/contractual')
                            ->disk('public')
                            ->allowedExtensions(['pdf'])
                            ->hint(__('moonshine::form.file.format'))
                            ->keepOriginalFileName()
                            ->removable()
                            ->hideOnIndex(),

                        Text::make('Текст второй ссылки', 'btn_2')
                            ->hideOnIndex(),

                        File::make('Файл второй ссылки', 'action_2')
                            ->dir('/files/contractual')
                            ->disk('public')
                            ->allowedExtensions(['pdf'])
                            ->hint(__('moonshine::form.file.format'))
                            ->keepOriginalFileName()
                            ->removable()
                            ->hideOnIndex()
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
        ImageEditor::resizeInAdmin(1140, 537);
        ImageEditor::resizeInAdmin(483, 512, 'block_1_img');
        ImageEditor::resizeInAdmin(1140, 507, 'block_2_img');
        ImageEditor::resizeInAdmin(1140, 507, 'block_3_img');
        ImageEditor::resizeInAdmin(1140, 507, 'block_4_img');
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(1140, 537);
        ImageEditor::resizeInAdmin(483, 512, 'block_1_img');
        ImageEditor::resizeInAdmin(1140, 507, 'block_2_img');
        ImageEditor::resizeInAdmin(1140, 507, 'block_3_img');
        ImageEditor::resizeInAdmin(1140, 507, 'block_4_img');
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete([$item->img, $item->block_1_img, $item->block_2_img, $item->block_3_img, $item->block_4_img]);
    }
}
