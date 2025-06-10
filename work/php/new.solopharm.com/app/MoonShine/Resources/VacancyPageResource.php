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
use MoonShine\Fields\Url;
use MoonShine\Fields\Image;
use MoonShine\Filters\SelectFilter;



class VacancyPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\VacancyPage';

    public static string $title = 'Вакансии';

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
                        Textarea::make(__('moonshine::form.field.title'), 'title')
                            ->hideOnIndex(),
                        Heading::make(__('moonshine::form.head.seo')),
                        Text::make(__('moonshine::form.field.seo.title'), 'seo_title')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex()
                    ]),
                    Tab::make('Описание', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_1_title')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'block_1_desc')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.caption'), 'block_1_caption')
                            ->hideOnIndex(),
                        Text::make(__('moonshine::form.field.url'), 'block_1_url')
                            ->hideOnIndex(),
                        Image::make(__('moonshine::form.field.img'), 'block_1_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 555x434.')
                            ->hideOnIndex()
                            ->removable(),
                    ]),
                    Tab::make('Вакансии', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_2_title')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'block_2_desc')
                            ->hideOnIndex(),
                        Text::make(__('moonshine::form.field.btn'), 'block_2_btn')
                            ->hideOnIndex(),
                        Text::make(__('moonshine::form.field.action'), 'block_2_action')
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
        ImageEditor::resizeInAdmin(555, 434, 'block_1_img');
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(555, 434, 'block_1_img');
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->block_1_img);
    }
}
