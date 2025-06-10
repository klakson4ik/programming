<?php

namespace App\Services\ImageService;

use App\Services\ImageService\Contracts\ImageManagerContract;
use App\Services\ImageService\Contracts\StorageContract;
use Exception;
use Intervention\Image\Image;

abstract class AbstractImageService
{
	/**
	 * Объект для работы непосредственно с созданием и сохранением изображения
	 *
	 * @var ImageManagerContract
	 */
	protected ImageManagerContract $manager;

	/**
	 * Массив с параметрами для работы сервиса.
	 * Обязательные ключи - sizes, format
	 *
	 * @var array|array[]
	 */
	protected array $config;

	/**
	 * Массив с параметрами изображения
	 *
	 * @var array
	 */
	protected array $imageParams;

	/**
	 * Оригинальный путь изображения
	 *
	 * @var string
	 */
	protected string $imagePath;

	/**
	 * Строка с параметрами для обработки изображения
	 *
	 * @var string
	 */
	protected string $paramsString;

	/**
	 * Массив с параметрами для обработки изображения
	 *
	 * @var array
	 */
	protected array $params;

	/**
	 * @var Image
	 */
	protected Image $image;

	protected StorageContract $storage;

	/**
	 * Новая директория для сохранения измененной картинки
	 *
	 * @var string
	 */
	protected string $newDir;

	/**
	 * Новый путь для сохранения измененной картинки
	 *
	 * @var string
	 */
	protected string $newPath;

	/**
	 * Нуждается ли картинка в конвертации в другой формат
	 *
	 * @var bool
	 */
	protected bool $needConvert;

	/**
	 * Нуждается ли картинка в изменении размера
	 *
	 * @var bool
	 */
	protected bool $needResize = true;

	/**
	 * @param string $path
	 * @param string $paramsString
	 * @param array $params
	 */
	public function __construct(string $path, string $paramsString = '', array $params = [])
	{
		$this->imagePath = $path;
		$this->paramsString = $paramsString;
		$this->params = $params;
	}

	/**
	 * Статическая обертка над конструктором
	 *
	 * @param string $path
	 * @param string $paramsString
	 * @param array $params
	 * @return static
	 */
	public static function make(string $path, string $paramsString = '', array $params = []): static
	{
		return new static($path, $paramsString, $params);
	}

	/**
	 * Подготавливает основные параметры для дальнейшей работы с картинкой
	 *
	 * @throws Exception
	 */
	public function setup(): static
	{
		$this->setParams();
		$this->validateParams();
		$this->setImageParams();
		$this->setNeedConvert();

		return $this;
	}

	public function getBasePath(): string
	{
		return $this->newPath;
	}

	public function getPath(): string
	{
		return $this->storage->path($this->newPath);
	}

	public function getUrl(): string
	{
		return $this->storage->url($this->newPath);
	}

	public function getModifyImages(string $returned_path = 'path'): array
	{
		$this->setImageParams();

		$images = [];
		$name = $this->imageParams['path_info']['filename'];
		$dir = $this->imageParams['path_info']['dirname'];
		$originPath = $dir . '/' . $this->imageParams['path_info']['basename'];
		$files = $this->storage->files($dir, true);

		foreach ($files as $file) {
			$pathInfo = pathinfo($file);
			$path = $pathInfo['dirname'] . '/' . $pathInfo['basename'];
			if ($pathInfo['filename'] === $name && $originPath !== $path) {
				$images[] = match ($returned_path) {
					'path' => $path,
					'url' => $this->storage->url($path),
					'storage' => $this->storage->path($path),
				};
			}
		}

		return $images;
	}

	/**
	 * Проверяет есть ли у картинки изменненые копии
	 *
	 * @return bool
	 */
	public function haveModifyImages(): bool
	{
		$this->setImageParams();

		$name = $this->imageParams['path_info']['filename'];
		$dir = $this->imageParams['path_info']['dirname'];
		$originPath = $dir . '/' . $this->imageParams['path_info']['basename'];
		$files = $this->storage->files($dir, true);

		foreach ($files as $file) {
			$pathInfo = pathinfo($file);
			$path = $pathInfo['dirname'] . '/' . $pathInfo['basename'];

			if ($pathInfo['filename'] === $name && $originPath !== $path) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Удаляет все изображения, связанные с оригинальным
	 *
	 * @param bool $deleteOrigin
	 * @return void
	 */
	public function delete(bool $deleteOrigin = true): void
	{
		$images = $this->getModifyImages();

		foreach ($images as $image) {
			$this->storage->delete($image);
		}

		if ($deleteOrigin) {
			$this->storage->delete($this->imageParams['path_info']['dirname'] . '/' . $this->imageParams['path_info']['basename']);
		}
	}

	/**
	 * Проводит манипуляции с изображением в рамках имеющихся параметров
	 *
	 * @return static
	 */
	public function process(): static
	{
		$this->setNewDir();
		$this->setNewPath();

		if (!$this->storage->exists($this->newDir)) {
			$this->storage->makeDirectory($this->newDir);
		}

		if (!$this->storage->exists($this->newPath)) {
			$this->manager->makeImage($this->imageParams['real_path']);
			$this->manager->setQuality($this->params['quality']);

			if ($this->needResize) {
				[$w, $h] = $this->getResizeValues();

				$this->manager->resizeImage($this->params['method'], $w, $h);
			}

			if ($this->needConvert) {
				$this->manager->convertImage($this->params['format']);
			}

			$this->manager->saveImage($this->storage->path($this->newPath));
		}

		return $this;
	}

	/**
	 * Проверяет необоходимали конвертация в другой формат
	 *
	 * @return void
	 */
	protected function setNeedConvert(): void
	{
		if (!isset($this->params['format'])) {
			$this->needConvert = false;
			return;
		}

		if (strtolower($this->imageParams['path_info']['extension']) === strtolower($this->params['format'])) {
			$this->needConvert = false;
			return;
		}

		if (
			$this->imageParams['path_info']['extension'] === 'jpg'
			&& $this->params['format'] === 'jpeg'
		) {
			$this->needConvert = false;
			return;
		}

		if (
			$this->imageParams['path_info']['extension'] === 'jpeg'
			&& $this->params['format'] === 'jpg'
		) {
			$this->needConvert = false;
			return;
		}

		$this->needConvert = true;
	}

	/**
	 * Создает новый путь до картинки
	 *
	 * @return void
	 */
	protected function setNewPath(): void
	{
		$this->newPath = $this->needConvert
			? $this->newDir . $this->imageParams['path_info']['filename'] . '.' . $this->params['format']
			: $this->newDir . $this->imageParams['path_info']['basename'];
	}

	/**
	 * Создает директорию на основе параметров для манимуляции с изображением
	 *
	 * @return void
	 */
	protected function setNewDir(): void
	{
		$newDir = $this->imageParams['path_info']['dirname'] . '/modify/' . $this->params['method'] . '/';

		if ($this->needResize) {
			$newDir .= $this->params['resize'] . '/';
		}

		if ($this->needConvert) {
			$newDir .= $this->params['format'] . '/';
		}

		$this->newDir = $newDir;
	}

	/**
	 * @return array
	 */
	protected function getResizeValues(): array
	{
		return array_map(function ($item) {
			return (int)$item;
		}, explode('x', $this->params['resize']));
	}

	/**
	 * @return void
	 */
	protected function setImageParams(): void
	{
		$storageStr = 'storage/';
		$this->imageParams = [
			'path_info' => pathinfo(str_replace($storageStr, '', $this->imagePath)),
			'real_path' => $this->storage->path($this->imagePath)
		];
	}

	/**
	 * @return void
	 */
	protected function setParams(): void
	{
		if (empty($this->params)) {
			$this->params = [
				'resize' => $this->extractValue($this->paramsString, 'r'),
				'format' => $this->extractValue($this->paramsString, 'f'),
				'quality' => $this->extractValue($this->paramsString, 'q'),
				'method' => $this->extractValue($this->paramsString, 'm'),
			];
		}
	}

	/**
	 * @throws Exception
	 */
	protected function validateParams(): void
	{
		if (isset($this->params['resize'])) {
			$this->validateSize();
		} else {
			$this->needResize = false;
		}

		if (isset($this->params['format'])) {
			$this->validateFormat();
		}

		$this->validateQuality();
		$this->validateMethod();
	}

	/**
	 * @throws Exception
	 */
	protected function validateMethod(): void
	{
		if (!isset($this->params['method'])) {
			$this->params['method'] = 'resize';
		}

		if (!in_array($this->params['method'], $this->config['methods'])) {
			throw new Exception('Метод для правки изображения не допустим');
		}
	}

	/**
	 * @throws Exception
	 */
	protected function validateSize(): void
	{
		if ($this->config['sizes'] === '*') {
			return;
		}

		if (!in_array($this->params['resize'], $this->config['sizes'])) {
			throw new Exception('Размер изображения не допустим');
		}
	}

	/**
	 * @throws Exception
	 */
	protected function validateFormat(): void
	{
		if (!in_array($this->params['format'], $this->config['format'])) {
			throw new Exception('Формат изображения не допустим');
		}
	}

	/**
	 * @return void
	 */
	protected function validateQuality(): void
	{
		if (!isset($this->params['quality'])) {
			$this->params['quality'] = 100;
		}

		if ($this->params['quality'] < 1) {
			$this->params['quality'] = 1;
		}

		if ($this->params['quality'] > 100) {
			$this->params['quality'] = 100;
		}
	}

	/**
	 * @param $imageString
	 * @param $char
	 * @return mixed|string|null
	 */
	protected function extractValue($imageString, $char): mixed
	{
		preg_match('/' . $char . '\/(.*?)\//', $imageString, $matches);
		return $matches[1] ?? null;
	}
}
