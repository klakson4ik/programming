<?php

namespace App\MoonShine\Resources;

use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;

class DevelopmentResource extends Resource
{
    public static string $model = 'App\Models\Development';

    public static string $title = 'Проекты и развитие';

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
                Heading::make('В фокусе'),
                Text::make(__('moonshine::form.field.url'), 'url')->hideOnIndex(),
                Image::make(__('moonshine::form.field.icon'), 'label')
                    ->dir('/images/development')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'gif', 'png', 'webp', 'svg'])
                    ->hint('jpg, png, svg, webp')
                    ->hideOnIndex()
                    ->removable(),
                Image::make(__('moonshine::form.field.img'), 'img')
                    ->dir('/images/development')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'gif', 'png', 'webp'])
                    ->hint('jpg, png, webp: 1700x600')
                    ->hideOnIndex()
                    ->removable(),
                Text::make(__('moonshine::form.field.text'), 'text_1')->hideOnIndex(),
                Heading::make('Без фокуса'),
                Text::make(__('moonshine::form.field.title'), 'title')
                    ->sortable(),
                Text::make(__('moonshine::form.field.text'), 'text_2')->hideOnIndex(),
                Text::make(__('moonshine::form.field.url'), 'url')->hideOnIndex(),
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['id'];
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

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete([$item->img, $item->label]);
    }
}
