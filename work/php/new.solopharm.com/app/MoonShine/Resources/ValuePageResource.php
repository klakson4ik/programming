<?php

namespace App\MoonShine\Resources;

use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Block;
use MoonShine\Fields\File;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\Image;
use MoonShine\Filters\SelectFilter;

class ValuePageResource extends Resource
{
    public static string $model = 'App\Models\Pages\ValuePage';

    public static string $title = 'Solopharm в цифрах';

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
                        Text::make(__('moonshine::form.field.title'), 'title_tooltip')->hideOnIndex(),
                        Heading::make(__('moonshine::form.head.seo')),
                        Text::make(__('moonshine::form.field.seo.title'), 'seo_title'),
                        Textarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex(),
                        Textarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex()
                    ]),
                    Tab::make('Видеоролик', [
                        Image::make(__('moonshine::form.field.img'), 'poster')
                            ->dir('/images/pages')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])
                            ->hint(__('moonshine::form.img.format') . ': 1140x498.')
                            ->hideOnIndex()
                            ->removable(),
                        File::make(__('moonshine::form.field.youtube'), 'youtube')
                            ->disk('public')
                            ->allowedExtensions(['asf', 'avi', 'mp4', 'm4v', 'mov', 'mpg', 'mpeg', 'wmv'])
                            ->hideOnIndex()
                            ->removable(),
                        Text::make('Заголовок хронологии', 'block_1_title')->hideOnIndex(),
                    ]),
                    Tab::make('Достижения', [
                        Text::make(__('moonshine::form.field.title'), 'block_2_title')->hideOnIndex(),
                        Text::make('Кнопка описание', 'block_2_btn_caption')->hideOnIndex(),
                        File::make(__('moonshine::form.file.name'), 'block_2_btn_link')
                            ->dir('/files/locations')
                            ->disk('public')
                            ->allowedExtensions(['pdf'])
                            ->keepOriginalFileName()
                            ->removable()
                            ->hint(__('moonshine::form.file.format'))
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Прогресс', [
                        TinyMce::make(__('moonshine::form.field.title'), 'block_3_title')->hideOnIndex(),
                    ]),
                    Tab::make('Страны экспорта', [
                        TinyMce::make(__('moonshine::form.field.title'), 'block_4_title')->hideOnIndex(),
                    ]),
                    Tab::make('Сегодня', [
                        TinyMce::make(__('moonshine::form.field.title'), 'block_5_title')->hideOnIndex(),
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
        return ['id', 'title'];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('moonshine::form.field.lang'), 'lang')
        ];
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->block_2_btn_link);
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
