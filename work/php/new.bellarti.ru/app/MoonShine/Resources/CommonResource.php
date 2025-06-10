<?php

namespace App\MoonShine\Resources;

use App\Models\Common;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;

class CommonResource extends BaseResource
{
    protected string $model = Common::class;

    protected string $title = 'Общие';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Название', 'name'),
                Text::make('Код', 'code')->hideOnAll(),
				Text::make('Значение', 'value')
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

}
