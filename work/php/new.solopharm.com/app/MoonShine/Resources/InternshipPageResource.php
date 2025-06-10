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



class InternshipPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\InternshipPage';

    public static string $title = 'Стажировка';

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
                        Textarea::make(__('moonshine::form.field.title'), 'title'),
                        Textarea::make(__('moonshine::form.field.desc'), 'desc')
                            ->hideOnIndex(),
                        Heading::make(__('moonshine::form.head.seo')),
                        Text::make(__('moonshine::form.field.seo.title'), 'seo_title')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex()
                    ]),
                    Tab::make('Направления стажировки', [
                        Textarea::make(__('moonshine::form.field.title'), 'internship_directions_title')->
                            hideOnIndex()
                    ]),
                    Tab::make('Заявки', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_1_title')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'block_1_desc')
                            ->hideOnIndex(),
                        Image::make(__('moonshine::form.field.img'), 'block_1_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 1140x500.')
                            ->hideOnIndex()
                            ->removable(),
                    ]),
                    Tab::make('В лаборатории', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_2_title')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'block_2_desc')
                            ->hideOnIndex(),
                        Image::make(__('moonshine::form.field.img'), 'block_2_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 540x368.')
                            ->hideOnIndex()
                            ->removable(),
                        Text::make(__('moonshine::form.field.btn'), 'block_2_btn')
                            ->hideOnIndex(),
                        Text::make(__('moonshine::form.field.action'), 'block_2_action')
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Приглашение', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_3_title')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'block_3_desc')
                            ->hideOnIndex(),
                        Image::make(__('moonshine::form.field.img'), 'block_3_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 540x368.')
                            ->hideOnIndex()
                            ->removable(),
                        Text::make(__('moonshine::form.field.caption'), 'block_3_caption')
                            ->hideOnIndex(),
                        Text::make(__('moonshine::form.field.url'), 'block_3_url')
                        ->hideOnIndex(),
                        Json::make('Направления в форме', 'form_directions')
                        ->fields([
                            Text::make(__('moonshine::form.field.text'), 'value')
                        ])->removable()
                            ->nullable()
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
        ImageEditor::resizeInAdmin(1140, 500, 'block_1_img');
        ImageEditor::resizeInAdmin(540, 368, 'block_2_img');
        ImageEditor::resizeInAdmin(540, 368, 'block_3_img');
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(1140, 500, 'block_1_img');
        ImageEditor::resizeInAdmin(540, 368, 'block_2_img');
        ImageEditor::resizeInAdmin(540, 368, 'block_3_img');
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete([$item->block_1_img, $item->block_2_img, $item->block_3_img]);
    }
}
