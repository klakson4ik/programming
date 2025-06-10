<?php

namespace App\Exports;

class TradesExport
{

    public function get($items, $fields)
    {
        $data = collect();
        foreach ($items as $item) {
            $instruction = $this->getValueByCode('instruction', $item);
            $direction = (isset($item->direction) && $item->direction) ? $item->direction->name : null;
            if ($direction === null) {
                $directions = (isset($item->product->direction) && $item->product->direction) ? $item->product->direction->toArray() : null;
                if ($directions) {
                    $direction = $this->expImplode($directions);
                }
            }

            $row = [
                'Язык' => $this->getValueByCode('lang', $item),
                'Опубликовать' => ($this->getValueByCode('active', $item) == "1") ? 'Да' : 'Нет',
                'Главный SKU' => ($this->getValueByCode('is_main', $item) == "1") ? 'Да' : 'Нет',
                'Сортировка' => $this->getValueByCode('sort', $item),
                'Форма выпуска' => $this->getValueByCode('form', $item),
                'URL' => $this->getValueByCode('url_slug', $item),
                'Препарат' => $item->product->title ?? 'Нет',
                'Технология' => $item->technology->title ?? 'Нет',
                'Изображение' => $this->getValueByCode('img', $item),
                'Страны экспорта' => $item->export_countries ? $this->expImplode($item->export_countries) : 'Нет',
                'Youtube' => $this->getValueByCode('youtube', $item),
                'Инструкция' => $instruction !== 'Нет' ? $_SERVER['APP_URL'] . '/storage/' . $instruction : 'Нет',
                'Сайт' => $this->getValueByCode('site', $item),
                'IQ provision' => $this->getValueByCode('IQ_provision', $item),
                'Направление(я)' => $direction ? $direction : 'Нет',
                'Состав' => $this->getValueByCode('compound', $item),
                'МНН' => $this->getValueByCode('MNN', $item),
                'Фармакотерапевтическая группа' => $this->getValueByCode('pharm', $item),
                'Показания к применению' => $this->getValueByCode('indications', $item),
                'Область применения' => $this->getValueByCode('scope', $item),
                'CE' => $this->getValueByCode('CE', $item) != 'Нет' ? 'Да' : 'Нет',
                'Экспорт' => $this->getValueByCode('export', $item) != 'Нет' ? 'Да' : 'Нет',
                'Новинка' => $this->getValueByCode('novelty', $item) != 'Нет' ? 'Да' : 'Нет',
                'Скоро' => $this->getValueByCode('soon', $item) != 'Нет' ? 'Да' : 'Нет',
                'ЖНВЛП' => $this->getValueByCode('vital', $item) != 'Нет' ? 'Да' : 'Нет',
                'Фарм область применения' => $this->getValueByCode('scope_pharm', $item),
                'Wildberries' => $this->getValueByCode('wb_link', $item),
                'ozon_link' => $this->getValueByCode('ozon_link', $item),
                'uteka_id' => $this->getValueByCode('uteka_id', $item),
                'ID продукта' => (isset($item->product->id) && $item->product->id) ? $item->product->id : '',
                'ID направления' => (isset($item->direction_id) && $item->direction_id) ? $item->direction_id : 'Нет',
                'ID технологии' => (isset($item->technology_id) && $item->technology_id) ? $item->technology_id : 'Нет',
            ];

            $data->add($row);
        }

        return $data;
    }

    private function getValueByCode($code, $item)
    {
        if (isset($item->$code) && $item->$code) {
            return strip_tags($item->$code);
        }
        if (isset($item->product->$code) && $item->product->$code) {
            return strip_tags($item->product->$code);
        }
        return 'Нет';
    }

    private function expImplode($array)
    {
        $str = '';
        foreach ($array as $value) {

			/*  
			Я хз что тут у вас происходит
			Но оно кидало 500 и я поставил 
			проверку на пустое 
			*/

            if (isset($value['value'])) {
                $str .= $value['value'] . ',';
            }
        }
        return rtrim($str, ',');
    }
}
