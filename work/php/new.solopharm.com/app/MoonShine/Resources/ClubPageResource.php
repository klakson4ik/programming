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
use MoonShine\Filters\SelectFilter;



class ClubPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\ClubPage';

    public static string $title = 'Клуб';

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
                        Heading::make(__('moonshine::form.head.seo')),
                        Text::make(__('moonshine::form.field.seo.title'), 'seo_title')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex()
                    ]),
                    Tab::make('Дополнительный текст', [
                        TinyMce::make('Текст в начале', 'top_text')->hideOnIndex()
                    ]),
                    Tab::make('Описание', [
                        Textarea::make(__('moonshine::form.field.title'), 'title')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'desc')
                            ->hideOnIndex(),
                        Image::make(__('moonshine::form.field.img'), 'img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 1140x498.')
                            ->hideOnIndex()
                            ->removable(),
                        Text::make(__('moonshine::form.field.youtube'), 'youtube')
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Мероприятия', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_1_title')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'block_1_desc')
                            ->hideOnIndex(),
                        Text::make(__('moonshine::form.field.text'), 'block_1_text')
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Обучение', [
                        Textarea::make(__('moonshine::form.field.title'), 'block_2_title')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.desc'), 'block_2_desc')
                            ->hideOnIndex(),
                        Image::make(__('moonshine::form.field.img'), 'block_2_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 1140x513.')
                            ->hideOnIndex()
                            ->removable(),
                        Textarea::make(__('moonshine::form.field.subtitle'), 'block_2_subtitle')
                            ->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.text'), 'block_2_text')
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Помещения', [
                        Textarea::make(__('moonshine::form.field.text'), 'block_3_text')
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
        ImageEditor::resizeInAdmin(1149, 498);
        ImageEditor::resizeInAdmin(1140, 513, 'block_2_img');
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(1140, 498);
        ImageEditor::resizeInAdmin(1140, 513, 'block_2_img');
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete([$item->block_2_img, $item->img]);
    }
}
