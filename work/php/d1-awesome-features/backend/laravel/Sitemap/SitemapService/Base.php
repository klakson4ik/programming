<?php

namespace App\Services\SitemapService;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Config;
use SebastianBergmann\Type\FalseType;

class Base
{
	private const PUBLIC_PATH  =  APP_PATH . 'public/';

	private string|false $timeZone;
	private array|false $models;
	private string $domain;
	private string $path;
	private int|false $fileMaxSize;
	private array $breedingUrls;
	private array $locs = [];
	private array|false $structure;
	private bool $checkActive;
	private string $fieldActive;
	private string $fieldUrl;

	public function __construct()
	{
		if (Config::has('sitemap')) {
			$config = Config::get('sitemap');
			$this->timeZone = $config['timezone'] ?? 'Europe/Moscow';
			$this->models = $config['models'] ?? false;
			$this->domain = $config['domain'] ?? Env::get('APP_URL');
			$this->path = $config['path'] ?? self::PUBLIC_PATH;
			$this->fileMaxSize = $config['file-max-size'] ?? false;
			$this->structure = $config['structure'] ?? false;
			$this->checkActive = $config['model-settings']['check-active'] ?? false;
			$this->fieldActive = $config['model-settings']['field-active'] ?? 'active';
			$this->fieldUrl = $config['model-settings']['field-url'] ?? 'url';
		} else {
			die('Файл конфигурации не существует');
		}
	}

	public function make(): void
	{
		$this->setTimeZone();
		$this->createSitemaps();
		if ($this->structure !== false) {
			$this->createStructure();
		}
		$this->breeding();
	}

	private function setTimeZone(): void
	{
		date_default_timezone_set($this->timeZone);
	}

	private function breeding(): void
	{
		$content = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
		foreach ($this->breedingUrls as $url) {
			$content .= '<sitemap>' . PHP_EOL
				. '<loc>' . $url . '</loc>' . PHP_EOL
				. '<lastmod>' . date('c', time()) .  '</lastmod>' . PHP_EOL
				. '</sitemap>' . PHP_EOL;
		}
		$content .= '</sitemapindex>';
		$file = $this->path . 'sitemap.xml';
		$this->createFile($file, $content);
	}

	private function createSitemaps()
	{
		if (!$this->models) {
			return;
		}
		foreach ($this->models as $modelName => $settings) {

			$model = 'App\\Models\\' . $modelName;
			if (class_exists($model)) {
				$result = [];
				$modelClass = new $model();
				$elements = $modelClass->all();
				$checkActive = $settings['check-active'] ?? $this->checkActive;
				$fieldActive = $settings['field-active'] ?? $this->fieldActive;
				$fieldUrl = $settings['field-url'] ?? $this->fieldUrl;

				foreach ($elements as $element) {
					if ($checkActive) {
						if ($element->$fieldActive) {
							$this->modelElementAdd($result, $element, $settings, $fieldUrl);
						}
					} else {
						$this->modelElementAdd($result, $element, $settings, $fieldUrl);
					}
				}
				$fileName = $settings['file-name'] ?? $modelClass->getTable();
				if ($this->fileMaxSize && count($result) > $this->fileMaxSize) {
					$countIblock = 1;
					$iblockChunks = array_chunk($result, $this->fileMaxSize);
					foreach ($iblockChunks as $chunk) {
						$this->createSitemap($chunk, $fileName, $countIblock++);
					}
				} else {
					$this->createSitemap($result, $fileName);
				}
			}
		}
	}

	private function modelElementAdd(array &$result, mixed $element, array $settings, string $fieldUrl): array|false
	{
		$startUrl = $this->domain . '/' . $settings['start-url'] . '/' ?? '';
		$loc = $startUrl . (isset($settings['method']) ? $this->locAction($settings['method'], $element) : $element->$fieldUrl);
		if (!in_array($loc, $this->locs)) {
			$result[] = $this->addCellValue(
				$loc,
				$settings['changefreq'] ?? 'weekly',
				$settings['lastmod'] ?? date('c', $element->updated_at->timestamp),
				$settings['priority'] ?? '0.5'
			);
			$this->locs[] = $loc;
			return $result;
		}
		return false;
	}

	private function createSitemap(array $data, string $code, int|false $count = false): void
	{
		$content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
		$content .= implode(PHP_EOL, array_map(fn ($item) => $this->cell($item), $data)) . PHP_EOL;
		$content .= '</urlset>';

		$file = 'sitemap-' . str_replace('_', '-', $code) . ($count ? '-' . $count : '') . '.xml';
		$this->breedingUrls[] = $this->domain . '/' . $file;
		$this->createFile($this->path . $file, $content);
	}

	private function cell(array $data): string
	{
		if ($data['loc']) {
			$cell = '<url>' . PHP_EOL;
			foreach ($data as $key => $value) {
				$cell .= '<' . $key . '>' . $value . '</' . $key . '>' . PHP_EOL;
			}
			return $cell .  '</url>';
		} else {
			return '';
		}
	}

	private function locAction(string $method, mixed $element): string
	{
		$class = 'App\\Services\\SitemapService\\LocAction';
		if (method_exists($class, $method)) {
			return call_user_func([$class, $method], $element);
		}
		return '';
	}

	private function createStructure(): void
	{
		$urls = RoutesFilter::get($this->structure['exclude'] ?? []);
		$urls = $this->addCustomUrls($urls);

		$result = array_map(fn ($item) => $this->addCellValue(
			$this->domain . '/' . $item . '/',
			$this->structure['changefreq'] ?? 'weekly',
			$this->structure['lastmod'] ?? date('c', time()),
			$this->structure['priority'] ?? '0.7'
		), $urls);

		array_unshift($result, $this->addCellValue($this->domain, 'daily', date('c', time()), '1'));
		$this->createSitemap($result, $this->structure['file-name'] ?? 'structure');
	}

	private function addCellValue(string $loc, string $changefreq, string $lastmod, string $priority): array
	{
		return [
			'loc' => $loc,
			'changefreq' => $changefreq,
			'lastmod' => $lastmod,
			'priority' => $priority
		];
	}

	private function addCustomUrls(array $current): array
	{
		if (!empty($this->structure['include'])) {
			foreach ($this->structure['include'] as $url) {
				$current[] = $url;
			}
		}
		return $current;
	}

	private function createFile($file, $content)
	{
		$fp = fopen($file, "w");
		fwrite($fp, $content);
		fclose($fp);
	}
}
