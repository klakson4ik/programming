<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use Illuminate\Support\Str;
use MoonShine\BulkActions\BulkAction;
use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Date;
use MoonShine\Fields\Json;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Textarea;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;
use MoonShine\Filters\TextFilter;

class VacancyResource extends Resource
{
    public static string $model = 'App\Models\Vacancy';

    public static string $title = 'Вакансии';

    public function fields(): array
    {
        return [
            Block::make('form-container', [
                Select::make(__('moonshine::form.field.lang'), 'lang')
                    ->options([
                        'ru' => __('moonshine::lang.ru'),
                        'en' => __('moonshine::lang.en')
                    ])
                    ->hideOnIndex(),
                Text::make('Город', 'city')->sortable(),
                Checkbox::make(__('moonshine::form.field.active'), 'active')
                    ->sortable(),
                Number::make(__('moonshine::form.field.sort'), 'sort')
                    ->min(0)
                    ->default(500)
                    ->sortable(),
                Text::make(__('moonshine::form.field.title'), 'title')
                ->sortable(),
                Text::make('Отдел', 'department')->sortable(),
                Slug::make('Url', 'url_slug')->from('title')->separator('-')->unique()->hideOnIndex(),
                Textarea::make('Описание', 'description')
                    ->nullable()
                    ->hideOnIndex(),
                Date::make(__('moonshine::form.field.date'), 'publish_at')
                    ->withTime()
                    ->nullable()
                    ->sortable()
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['title', 'department', 'city'];
    }

    public function filters(): array
    {
        return [
            SwitchBooleanFilter::make(__('moonshine::form.field.active'), 'active'),
            SelectFilter::make('Город', 'city')
                ->options([
                    'Санкт-Петербург' => 'Санкт-Петербург',
                    'Москва' => 'Москва',
                ])->nullable(),
            TextFilter::make('Отдел', 'department')->nullable()
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }

    public function bulkActions(): array 
    {
        return [
            BulkAction::make('', function (Model $item) {
                $item->update(['active' => true]);
            }, 'Активирован')->icon('heroicons.eye')
            ->showInLine()
            ->withConfirm(),
            BulkAction::make('', function (Model $item) {
                $item->update(['active' => false]);
            }, 'Деактивирован')->icon('heroicons.eye-slash')
            ->showInLine()
            ->withConfirm()
        ];
    } 

    public function trClass(Model $item, int $index): string 
    {
        if($item->active == 0) {
            return 'blue';
        }
 
        return parent::trClass($item, $index);
    }
}
