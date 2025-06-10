<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use App\MoonShine\Fields\Mapeditor;
use MoonShine\Fields\NoInput;



class CountryResource extends Resource
{
    public static string $model = 'App\Models\Country';

    public static string $title = 'Country';

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
                Select::make(__('moonshine::form.field.page'), 'page')
                    ->options([
                        1 => 'Solopharm в цифрах',
                        2 => 'Экспортные рынки'
                    ])
                    ->sortable(),
                Text::make(__('moonshine::form.field.name'), 'name')->sortable(),
                Text::make('Флаг', 'flag')->hideOnIndex(),
                NoInput::make('', 'no_input', static function () {
                    return view('fields.test');
                })->hideOnIndex(),
                Text::make('Top', 'top')->hideOnIndex(),
                Text::make('Left', 'left')->hideOnIndex(),
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
}
