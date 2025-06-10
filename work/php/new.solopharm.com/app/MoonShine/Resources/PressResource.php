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
use Illuminate\Support\Str;
use MoonShine\Fields\CKEditor;
use MoonShine\Fields\Image;
use MoonShine\Fields\Date;
use MoonShine\Fields\Number;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\TinyMce;

class PressResource extends Resource
{
    public static string $model = 'App\Models\Press';

    public static string $title = 'Пресса';

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
                Text::make(__('moonshine::form.field.title'), 'title')
                    ->sortable()
                    ->required(),
                Slug::make('Url', 'url_slug')->from('title')->separator('-')->unique(),
                Text::make(__('moonshine::form.field.desc'), 'description')
                    ->sortable()
                    ->hideOnIndex(),
                Text::make(__('moonshine::form.field.tag'), 'tag')
                    ->sortable()
                    ->hideOnIndex(),
                Text::make('Url тега', 'tag_url')
                    ->sortable()
                    ->hideOnIndex(),
                Image::make(__('moonshine::form.field.img'), 'img')
                    ->dir('/images/press')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
                    ->hint('jpg, png, webp: 540x300')
                    ->hideOnIndex()
                    ->removable(),
                TinyMce::make('Текст', 'text')
                    ->hideOnIndex(),
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
        ImageEditor::resizeInAdmin(540, 300);
    }

    protected function beforeUpdating(Model $item)
    {
        ImageEditor::resizeInAdmin(540, 300);
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->img);
        StorageHelper::delete($item->img_detail);
    }
}
