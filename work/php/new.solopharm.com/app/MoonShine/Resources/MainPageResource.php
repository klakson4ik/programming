<?php

namespace App\MoonShine\Resources;

use App\Helpers\ImageEditor;
use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Filters\SelectFilter;

class MainPageResource extends Resource
{
    public static string $model = 'App\Models\Pages\MainPage';

    public static string $title = 'Главная страница';

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
                        Heading::make('SEO'),
                        Text::make('Title', 'seo_title'),
                        Textarea::make('Desicription', 'seo_description')->hideOnIndex(),
                        Textarea::make('Keywords', 'seo_keywords')->hideOnIndex()
                    ]),
                    Tab::make('Экран приветствия', [
                        Text::make(__('moonshine::form.field.title'), 'block_1_title')->hideOnIndex(),
                        Text::make('Teкст 1', 'block_1_text_1')->hideOnIndex(),
                        Text::make('Teкст 2', 'block_1_text_2')->hideOnIndex(),
                        Image::make(__('moonshine::form.field.img'), 'block_1_img')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
                            ->hint('jpg, png, webp: 2600x800')
                            ->hideOnIndex()
                            ->removable()
                    ]),
                    Tab::make('Наша миссия', [
                        Text::make('Заголовок', 'block_2_title')->hideOnIndex(),
                        Textarea::make('Текст слева', 'block_2_description')->hideOnIndex(),
                        Json::make('Teкст справа', 'block_2_text')
                            ->fields([
                                Textarea::make('Заголовок', 'title'),
                                Textarea::make('Текст', 'value')
                            ])
                            ->removable()
                            ->nullable()
                            ->hideOnIndex(),
                        Text::make('Кнопка описание', 'block_2_btn_caption')->hideOnIndex(),
                        Text::make('кнопка ссылка', 'block_2_btn_link')->hideOnIndex()
                    ]),
                    Tab::make('Проекты и развитие', [
                        Text::make('Заголовок', 'block_3_title')->hideOnIndex(),
                    ]),
                    Tab::make('Направления', [
                        Text::make('Заголовок', 'block_4_title')->hideOnIndex(),
                        Text::make('Ссылка подпись', 'block_4_url_caption')->hideOnIndex(),
                        Text::make('Ссылка ссылка', 'block_4_url_link')->hideOnIndex(),
                    ]),
                    Tab::make('Новости', [
                        Text::make('Заголовок', 'block_5_title')->hideOnIndex(),
                        Text::make('Ссылка подпись', 'block_5_url_caption')->hideOnIndex(),
                        Text::make('Ссылка ссылка', 'block_5_url_link')->hideOnIndex(),
                    ]),
                    Tab::make('Проекты', [
                        Text::make('Заголовок', 'block_6_title')->hideOnIndex(),
                        Textarea::make('Текст', 'block_6_text')->hideOnIndex(),
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
        return ['seo_title'];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('moonshine::form.field.lang'), 'language')
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

    protected function beforeCreating(Model $item)
    {
        ImageEditor::resizeInAdmin(2600, 800, 'block_1_img');
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(2600, 800, 'block_1_img');
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->block_1_img);
    }
}
