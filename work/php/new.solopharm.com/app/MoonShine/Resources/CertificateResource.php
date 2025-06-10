<?php

namespace App\MoonShine\Resources;

use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Date;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Number;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\File;
use MoonShine\Fields\Text;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;



class CertificateResource extends Resource
{
    public static string $model = 'App\Models\Certificate';

    public static string $title = 'Сертификаты';

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
                    ->sortable()
                    ->default(1),

                Number::make(__('moonshine::form.field.sort'), 'sort')
                    ->min(0)
                    ->default(500)
                    ->sortable(),

                Text::make(__('moonshine::form.field.title'), 'title'),

                TinyMce::make(__('moonshine::form.field.desc'), 'desc')
                    ->hideOnIndex(),
                TinyMce::make('Текст для сертификата', 'additional_text')
                    ->hideOnIndex(),

                Text::make('Статус', 'text')
                    ->hideOnIndex(),

                File::make(__('moonshine::form.field.file'), 'file')
                    ->dir('/files/certificates')
                    ->disk('public')
                    ->allowedExtensions(['pdf'])
                    ->hint(__('moonshine::form.file.format'))
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
        return [
            SelectFilter::make(__('moonshine::form.field.lang'), 'lang')
                ->options([
                    'ru' => __('moonshine::lang.ru'),
                    'en' => __('moonshine::lang.en')
                ])->nullable(),

            SwitchBooleanFilter::make(__('moonshine::form.field.active'), 'active')
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }

    protected function afterDeleted(Model $item)
    {
        StorageHelper::delete($item->file);
    }
}
