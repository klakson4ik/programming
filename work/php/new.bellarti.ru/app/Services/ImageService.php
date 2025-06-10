<?php

namespace App\Services;

use Techart\ImageService\Managers\InterventionImageManager;
use \Techart\ImageService\Service;
use \Techart\ImageService\Storages\StandardStorage;
use \Techart\ImageService\Storages\LaravelStorage;
use \App\Helpers\StorageHelpers;

class ImageService
{
    public $service;

    /**
     * @param $laravelStorage если true, то будет использовано хранилище laravel. Иначе используется стандартное
     */
    function __construct($laravelStorage = false)
    {
        $manager = new InterventionImageManager();
        if($laravelStorage) {
            $storage = LaravelStorage::getInstance();
        } else {
            $storage = StandardStorage::getInstance();
        }
        $config = [
            'sizes' => '*',
            'format' => [
                'webp',
                'jpg',
                'jpeg',
                'png',
                'gif',
            ],
            'methods' => [
                'resize',
                'crop',
                'fit',
            ]
        ];

        $this->service = Service::getInstance($manager, $storage, $config);
    }

    /**
     * Получает и при необходимости конвертирует изображение в формат webp
     *
     * @param string $path путь к изображению относительно выбранного хранилища
     * @return string путь к изображению в формате webp
     */
    public function getWebp(string $path)
    {
        return $this->service->modify($path)->setFormat('webp')->process()->getUrl();
    }

    /**
     * Получает массив с модифицированными картинками
     *
     * @param string $path путь к изображению относительно выбранного хранилища
     * @param array $sizes размеры изображений
     * @param bool $useKeys если true, то ключи массива $sizes будут применены к результирущему массиву. Иначе в качестве ключей будут использованы размеры
     * @return array массив с измененными картинками
     */
    public function getResizedArray(string $path, array $sizes, bool $useKeys = true): array
    {
        $images = [];

        foreach($sizes as $key => $size) {
            $index = $useKeys === true ? $key : $size;

            $images['mods'][$index] = $this->service->modify($path, [
                'resize' => $size,
                'format' => 'webp'
            ])->process()->getUrl();
        }

        $images['src'] = $this->getWebp($path);

        return $images;
    }

    /**
     * Возвращает модифицированную картинку
     *
     * @param string $path путь к картинке относительно выбранного хранилища
     * @param string $size разрешение, к которому нужно привести картинку
     * @return string путь к измененной картинке
     */
    public function getResizedImage(string $path, string $size): string
    {
        return $this->service->modify($path, [
            'resize' => $size,
            'format' => 'webp'
        ])->process()->getUrl();
    }

    /**
     * Удаляет модификации изображения
     *
     * @param string $path путь к изображению относительно выбранного хранилища
     * @param bool $removeOrig если установлен true, то будет удалён и оригинал картинки
     */
    public function removeImage(string $path, bool $removeOrig = true): void
    {
        if(!file_exists(StorageHelpers::getPathFromStorage($path))) {
            return;
        }
        $storage = $this->service->storage($path);

        if($storage->haveModifyImages()) {
            $storage->delete($removeOrig);
        }
    }
}
