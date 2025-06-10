<?php

namespace App\MoonShine\Resources;

use App\Helpers\ImageEditor;
use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\TinyMce;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Json;
use MoonShine\Fields\Image;

class RndPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\RndPage';

    public static string $title = 'RndPage';

    public function fields(): array
    {
        return [
            Block::make('Основное', [
                Tabs::make([
                    Tab::make(__('moonshine::form.tab.main'), [
                        Select::make(__('moonshine::form.field.lang'), 'lang')
                            ->options([
                                'ru' => __('moonshine::lang.ru'),
                                'en' => __('moonshine::lang.en')
                            ]),
                        Textarea::make(__('moonshine::form.field.title'), 'title'),
                        Heading::make(__('moonshine::form.head.seo')),
                        Text::make(__('moonshine::form.field.seo.title'), 'seo_title'),
                        Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex()
                    ]),
                    Tab::make('Приветствие', [
                        Text::make(__('moonshine::form.field.subtitle'), 'subtitle')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'desc')->hideOnIndex(),
                        Image::make(__('moonshine::form.field.img'), 'block_1_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
                            ->hint('jpg, png, webp: 1140x637')
                            ->hideOnIndex()
                            ->removable(),
                        Json::make('Данные на изображении', 'block_1_data')
                            ->fields([
                                Textarea::make(__('moonshine::form.field.title'), 'title'),
                                Textarea::make(__('moonshine::form.field.text'), 'value')
                            ])->removable()
                            ->nullable()
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Отдел разработки', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_2_title')->hideOnIndex(),
                        Json::make(__('moonshine::form.field.data'), 'block_2_data')
                            ->fields([
                                Textarea::make(__('moonshine::form.field.title'), 'title'),
                                Textarea::make(__('moonshine::form.field.text'), 'value')
                            ])->removable()
                            ->nullable()
                            ->hideOnIndex(),
                        Image::make(__('moonshine::form.field.imgs'), 'block_2_imgs')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
                            ->hint('jpg, png, webp: 545x391. Можно выбрать несколько изображений')
                            ->multiple()
                            ->removable()
                            ->nullable()
                            ->hideOnIndex()
                            ->removable(),
                    ]),
                    Tab::make('Биотехнологии', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_3_title')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.text'), 'block_3_text')->hideOnIndex(),
                        Image::make(__('moonshine::form.field.img'), 'block_3_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
                            ->hint('jpg, png, webp: 665x358')
                            ->removable()
                            ->hideOnIndex()
                            ->removable(),
                        Json::make(__('moonshine::form.field.data'), 'block_3_data')
                            ->fields([
                                Textarea::make(__('moonshine::form.field.number'), 'title'),
                                Textarea::make(__('moonshine::form.field.text'), 'value')
                            ])->removable()
                            ->nullable()
                            ->hideOnIndex(),
                    ]),
                ])
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
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }

    protected function beforeCreating(Model $item)
    {
        ImageEditor::resizeInAdmin(1140, 637, 'block_1_img');
        ImageEditor::resizeInAdminMultiple(545, 391, 'block_2_imgs');
        ImageEditor::resizeInAdmin(665, 358, 'block_3_img');
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(1140, 637, 'block_1_img');
        ImageEditor::resizeInAdminMultiple(545, 391, 'block_2_imgs');
        ImageEditor::resizeInAdmin(665, 358, 'block_3_img');
    }

    protected function beforeDeleting(Model $item)
    {
        StorageHelper::delete([$item->block_1_img, $item->block_3_img]);
        StorageHelper::deleteAll($item->block_2_imgs);
    }
}
