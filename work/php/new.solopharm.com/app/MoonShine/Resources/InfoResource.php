<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use MoonShine\Resources\Resource;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Select;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Heading;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\Email;
use MoonShine\Fields\Json;
use MoonShine\Fields\Phone;
use MoonShine\Fields\Textarea;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;



class InfoResource extends Resource
{
    public static string $model = 'App\Models\Info';

    public static string $title = 'Информация';

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
                            ])
                            ->sortable(),
                        Textarea::make('Адрес', 'address')->hideOnIndex(),
                        Textarea::make('Адрес ссылка', 'address_url')->hideOnIndex(),
                        Email::make('Email', 'email')->hideOnIndex(),
                        Phone::make('Телефон', 'phone')->hideOnIndex(),
                    ]),
                    Tab::make('Меню в Футере', [
                        Json::make('Меню в футоре', 'menu')
                            ->fields([
                                Text::make(__('moonshine::form.field.name'), 'value'),
                                Text::make(__('moonshine::form.field.url'), 'url')
                            ])->removable()
                            ->nullable()
                            ->fullWidth()
                            ->hideOnIndex(),
                    ]),
                    Tab::make('Социальные сети в футере', [
                        Heading::make('Вконтакте'),
                        Flex::make('', [
                            SwitchBoolean::make(__('moonshine::form.field.active'), 'is_vk')->hideOnIndex(),
                            Text::make(__('moonshine::form.field.url'), 'vk_url')->hideOnIndex(),
                        ]),
                        Heading::make('Youtube'),
                        Flex::make('', [
                            SwitchBoolean::make(__('moonshine::form.field.active'), 'is_youtube')->hideOnIndex(),
                            Text::make(__('moonshine::form.field.url'), 'youtube_url')->hideOnIndex(),
                        ]),
                        Heading::make('Linkedin'),
                        Flex::make('', [
                            SwitchBoolean::make(__('moonshine::form.field.active'), 'is_linkedin')->hideOnIndex(),
                            Text::make(__('moonshine::form.field.url'), 'linkedin_url')->hideOnIndex(),
                        ]),
                        Heading::make('Одноклассники'),
                        Flex::make('', [
                            SwitchBoolean::make(__('moonshine::form.field.active'), 'is_ok')->hideOnIndex(),
                            Text::make(__('moonshine::form.field.url'), 'ok_url')->hideOnIndex(),
                        ]),
                        Heading::make('Telegram'),
                        Flex::make('', [
                            SwitchBoolean::make(__('moonshine::form.field.active'), 'is_telegram')->hideOnIndex(),
                            Text::make(__('moonshine::form.field.url'), 'telegram_url')->hideOnIndex(),
                        ]),
                        Heading::make('Яндекс Zen'),
                        Flex::make('', [
                            SwitchBoolean::make(__('moonshine::form.field.active'), 'is_zen')->hideOnIndex(),
                            Text::make(__('moonshine::form.field.url'), 'zen_url')->hideOnIndex(),
                        ]),
                        Heading::make('IQ-provision'),
                        Flex::make('', [
                            SwitchBoolean::make(__('moonshine::form.field.active'), 'is_iq')->hideOnIndex(),
                            Text::make(__('moonshine::form.field.url'), 'iq_url')->hideOnIndex(),
                        ]),
                    ])
                ])
            ])
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
}
