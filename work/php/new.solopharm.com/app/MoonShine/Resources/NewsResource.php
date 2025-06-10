<?php

namespace App\MoonShine\Resources;

use App\Helpers\ImageEditor;
use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Date;
use MoonShine\Fields\Number;
use MoonShine\Fields\Slug;
use MoonShine\Fields\TinyMce;

class NewsResource extends Resource
{
    public static string $model = 'App\Models\News';

    public static string $title = 'Новости';

    public function fields(): array
    {
        return [
            Block::make('form-container', [
                Select::make(__('moonshine::form.field.lang'), 'lang')
                    ->options([
                        'ru' => __('moonshine::lang.ru'),
                        'en' => __('moonshine::lang.en')
                    ])
                    ->sortable(),
                SwitchBoolean::make(__('moonshine::form.field.active'), 'active')
                    ->sortable(),
                Number::make(__('moonshine::form.field.sort'), 'sort')
                    ->min(0)
                    ->default(500)
                    ->sortable(),
                SwitchBoolean::make('Опубликовать на главной', 'show_in_main')
                    ->sortable(),
                Text::make(__('moonshine::form.field.title'), 'title')
                    ->sortable()
                    ->required(),
                Slug::make('Url', 'url_slug')->from('title')->separator('-')->unique(),
                Image::make(__('moonshine::form.field.img'), 'img')
                    ->dir('/images/news')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
                    ->hint('jpg, png, webp: 380x480')
                    ->hideOnIndex()
                    ->removable(),
                TinyMce::make('Текст', 'text')->hideOnIndex(),
                Date::make(__('moonshine::form.field.date'), 'date')
                    ->format('d.m.Y')
                    ->nullable()
                    ->hideOnIndex()
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
        ImageEditor::resizeInAdmin(380, 480);
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(380, 480);
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->img);
        StorageHelper::delete($item->img_detail);
    }
}
