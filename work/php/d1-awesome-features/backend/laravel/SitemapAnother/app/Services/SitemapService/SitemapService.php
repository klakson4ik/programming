<?php
namespace App\Services\SitemapService;

use Illuminate\Support\Env;
use Illuminate\Support\Facades\Config;

class SitemapService
{
	const CONFIG_KEY = 'sitemap';
	private string|false $timeZone;
	private string $domain;
	private string $path;
	private int|false $fileMaxSize;
	private string|bool $postfix;
	private array $staticRoutes;
	private array $models;
	private array $breedingUrls = [];
	private array|bool $locales = [];
	private array $modelSettings = [
		'separateFiles' => false,
		'lastmod' => 'updated_at',
		'changefreq' => false,
		'priority' => false
	];
	private array $baseRecords = [];
	private array $records = [];

	public function __construct()
	{
		if (Config::has(self::CONFIG_KEY)) {
			$config = Config::get(self::CONFIG_KEY);
			$this->timeZone = $config['timezone'] ?? 'Europe/Moscow';
			$this->domain = $config['domain'] ?? Env::get('APP_URL');
			$this->path = $config['path'] ?? base_path('public');
			$this->fileMaxSize = $config['fileMaxSize'] ?? 10000;
			$this->staticRoutes = $config['staticRoutes'] ?? [];
			$this->models = $config['models'] ?? [];
			$this->postfix = $config['postfix'] ?? false;
			$this->locales = $config['locales'] ?? false;
			$modelSettings = $config['modelsSettings'] ?? [];
			$this->modelSettings['separateFiles'] = $modelSettings['separateFiles'] ?? $this->modelSettings['separateFiles'];
			$this->modelSettings['lastmod'] = $modelSettings['lastmod'] ?? $this->modelSettings['lastmod'];
			$this->modelSettings['changefreq'] = $modelSettings['changefreq'] ?? $this->modelSettings['changefreq'];
			$this->modelSettings['priority'] = $modelSettings['priority'] ?? $this->modelSettings['priority'];
			if($this->modelSettings['separateFiles'] === true) {
				$this->records = [
					'static' => [],
					'models' => []
				];
			}
		} else {
			die('Файл конфигурации не существует');
		}
	}

	/**
	 * Возвращает значение настройки разбиения сайтмапа на несколько файлов(статичные и сайтмапы моделей)
	 */
	private function isSeparate(): bool {
		return $this->modelSettings['separateFiles'];
	}

	/**
	 * Сгененировать сайтмап
	 * @return void
	 */
	public function make()
	{
		$this->setTimeZone();
		$this->setStatics();
		$this->setModels();
		$this->prepareDataToWrite();
		$this->createSitemap();
	}

	/**
	 * Получает текущий url с префиксом, если такой установлен
	 * 
	 * @return string url с префиксом
	 */
	private function getUrlPrefix(): string {
		if(!$this->locales || (count($this->locales) === 0)) {
			return $this->domain;
		} else {
			return $this->domain . $this->locales['prefix'] . '/';
		}
	}

	/**
	 * Получает полную ссылку на страницу
	 * 
	 * @param string $url ссылка на страницу
	 * @return array|string|null
	 */
	private function getFullLink(string $url): array|string|null {
		$fullLink = $this->getUrlPrefix() . '/' . $url;
		if($this->postfix !== false) {
			$fullLink .= $this->postfix;
		}
		$fullLink = preg_replace('/([^:])(\/{2,})/', '$1/', $fullLink);
		return $fullLink;
	}

	/**
	 * Устпнавливает таймзону по умолчанию из настроек
	 * 
	 * @return void
	 */
	private function setTimeZone(): void
	{
		date_default_timezone_set($this->timeZone);
	}

	/**
	 * Устанавливает пути статичных страниц в сайтмап из настроек
	 * 
	 * @return void
	 */
	private function setStatics(): void
	{
		foreach($this->staticRoutes as $routeName) {
			$fullLink = $this->getFullLink(route($routeName, [], false));

			if($this->isSeparate()) {
				$this->records['static'][] = [
					'url' => $fullLink
				];
			} else {
				$this->records[] = [
					'url' => $fullLink
				];
			}
		}
		if($this->isSeparate()) {
			uasort($this->records['static'], function($a, $b) {
				return $a['url'] > $b['url'];
			});
		} else {
			uasort($this->records, function($a, $b) {
				return $a['url'] > $b['url'];
			});
		}
	}

	/**
	 * Устанавливает пути динамичных страниц в сайтмап из настроект
	 * 
	 * @return void
	 */
	private function setModels(): void
	{
		foreach($this->models as $modelName => $settings) {
			$modelClass = 'App\\Models\\' . $modelName;
			if(!isset($settings['lastmod'])) {
				$settings['lastmod'] = $this->modelSettings['lastmod'];
			}
			if(!isset($settings['changefreq'])) {
				$settings['changefreq'] = $this->modelSettings['changefreq'];
			}
			if(!isset($settings['priority'])) {
				$settings['priority'] = $this->modelSettings['priority'];
			}
			if(class_exists($modelClass)) {
				$model = new $modelClass();
				$query = $model::query();
				$multipleLinks = false;
				if(isset($settings['whereCondition']) && $settings['whereCondition']) {
					foreach($settings['whereCondition'] as $key => $value) {
						$query->where($key, $value);
					}
				}
				$items = $query->get();
				foreach($items as $item) {
					$data = [];

					if(isset($settings['url'])) {
						if(gettype($settings['url']) === 'object') {
							$url = $settings['url']($item);
						} else if(gettype($settings['url'] === 'string')) {
							$url = $settings['url'];
						}
					} else {
						$url = '';
					}

					if(gettype($url) === 'string') {
						$data['url'] = $this->getFullLink($url);
					} else if(gettype($url) === 'array') {
						foreach($url as $link) {
							$data[]['url'] = $this->getFullLink($link);
						}
						$multipleLinks = true;
					}

					if($settings['lastmod'] !== false) {
						if(isset($item[$settings['lastmod']])) {
							$dateTime = $item[$settings['lastmod']]->format('c');
						} else {
							$timestamp = strtotime($settings['lastmod']);
							$dateTime = date('c', $timestamp);
						}
						if($multipleLinks) {
							foreach($data as &$item) {
								$item['lastmod'] = $dateTime;
							}
							unset($item);
						} else {
							$data['lastmod'] = $dateTime;
						}
					}

					if($settings['changefreq'] !== false) {
						if(isset($item[$settings['changefreq']])) {
							$changefreq = $item[$settings['changefreq']];
						} else {
							$changefreq = $settings['changefreq'];
						}
						if($multipleLinks) {
							foreach($data as &$item) {
								$item['changefreq'] = $changefreq;
							}
							unset($item);
						} else {
							$data['changefreq'] = $changefreq;
						}
					}

					if($settings['priority'] !== false) {
						if(isset($item[$settings['priority']])) {
							$priority = $item[$settings['priority']];
						} else {
							$priority = $settings['priority'];
						}
						if($multipleLinks) {
							foreach($data as &$item) {
								$item['priority'] = $priority;
							}
							unset($item);
						} else {
							$data['priority'] = $priority;
						}
					}

					if($this->isSeparate()) {
						if($multipleLinks) {
							$modelsArr = $this->records['models'][$modelName] ?? [];
							$this->records['models'][$modelName] = array_merge($modelsArr, $data);
						} else {
							$this->records['models'][$modelName][] = $data;
						}
					} else {
						if($multipleLinks) {
							$this->records = array_merge($this->records, $data);
						} else {
							$this->records[] = $data;
						}
					}
				}
			}
			if($this->isSeparate()) {
				uasort($this->records['models'][$modelName], function($a, $b) {
					return $a['url'] > $b['url'];
				});
			} else {
				uasort($this->records, function($a, $b) {
					return $a['url'] > $b['url'];
				});
			}
		}
	}

	/**
	 * Подготавливает данные для генерации сайтмапа
	 * 
	 * @return void
	 */
	private function prepareDataToWrite(): void {
		if($this->isSeparate()) {
			$staticChunks = ceil(count($this->records['static']) / $this->fileMaxSize);
			if($staticChunks > 1) {
				for($i = 0; $i < $staticChunks; $i++) {
					$this->baseRecords[] = [
						'url' => $this->domain . 'sitemap-static-' . $i + 1 . '.xml',
						'lastmod' => date('c')
					];
				}
			} else {
				$this->baseRecords[] = [
					'url' => $this->domain . 'sitemap-static.xml',
					'lastmod' => date('c')
				];
			}
			foreach($this->records['models'] as $modelName => $modelRecords) {
				$modelChunks = ceil(count($modelRecords) / $this->fileMaxSize);
				$modelSitemapName = $this->getModelSitemapName($modelName);
				if($modelChunks > 1) {
					for($i = 0; $i < $modelChunks; $i++) {
						$this->baseRecords[] = [
							'url' => $this->domain . 'sitemap-' . $modelSitemapName . '-' . $i + 1 . '.xml',
							'lastmod' => date('c')
						];
					}
				} else {
					$this->baseRecords[] = [
						'url' => $this->domain . 'sitemap-' . $modelSitemapName . '.xml',
						'lastmod' => date('c')
					];
				}
			}
		} else {
			$chunksCount = ceil(count($this->records) / $this->fileMaxSize);
			if($chunksCount > 1) {
				for($i = 0; $i < $chunksCount; $i++) {
					$this->baseRecords[] = [
						'url' => $this->domain . 'sitemap-part-' . $i + 1 . '.xml',
						'lastmod' => date('c')
					];
				}
			}
		}
	}

	/**
	 * Создаёт сайтмап
	 * 
	 * @return void
	 */
	private function createSitemap(): void {
		if(count($this->baseRecords) !== 0) {
			$this->writeSitemapBase($this->baseRecords, $this->path . 'sitemap.xml');
			if($this->isSeparate()) {
				if(count($this->records['static']) > 0) {
					$staticChunks = array_chunk(
						$this->records['static'],
						ceil($this->fileMaxSize)
						);
					if(count($staticChunks) > 1) {
						foreach($staticChunks as $id => $chunk) {
							$this->writeSitemap($chunk, $this->path . 'sitemap-static-' . $id + 1 . '.xml');
						}
					} else {
						$this->writeSitemap($this->records['static'], $this->path . 'sitemap-static.xml');
					}
				}
				if(count($this->records['models']) > 0) {
					foreach($this->records['models'] as $modelName => $modelRecords) {
						$modelChunks = array_chunk(
							$modelRecords,
							ceil($this->fileMaxSize)
						);
						$modelSitemapName = $this->getModelSitemapName($modelName);
						if(count($modelChunks) > 1) {
							foreach($modelChunks as $id => $chunk) {
								$this->writeSitemap($chunk, $this->path . 'sitemap-' . $modelSitemapName . '-' . $id + 1 . '.xml');
							}
						} else {
							$this->writeSitemap($modelRecords, $this->path . 'sitemap-' . $modelSitemapName . '.xml');
						}
					}
				}
			} else {
				if(count($this->records) > 0) {
					$chunks = array_chunk(
						$this->records,
						ceil($this->fileMaxSize)
					);
					foreach($chunks as $id => $chunk) {
						$this->writeSitemap($chunk, $this->path . 'sitemap-part-' . $id + 1 . '.xml');
					}
				}
			}
		} else {
			$this->writeSitemap($this->records, $this->path . 'sitemap.xml');
		}
	}

	/**
	 * Генерирует имя файла для сайтмапа модели
	 * @param string $modelName имя модели
	 * @return string имя файла сайтмапа модели
	 */
	private function getModelSitemapName(string $modelName): string {
		$modelSitemapName = preg_replace('/(.*\\\{1,})/', '', $modelName);
		$modelSitemapName = strtolower(preg_replace('/(.+)([A-Z])/', '$1-$2', $modelSitemapName));
		return $modelSitemapName;
	}

	/**
	 * Генерирует и записывает базовый сайтмап
	 * 
	 * @param array $values значения, записываемые в файл
	 * @param string $filePath путь к файлу сайтмапа
	 * @return void
	 */
	private function writeSitemapBase(array $values, string $filePath): void {
		$content = '<?xml version="1.0" encoding="UTF-8"?>' .
			'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach($values as $value) {
			$content .= '<sitemap>';
			$content .= '<loc>' . $value['url'] . '</loc>';
			if(isset($value['lastmod']) && $value['lastmod']) {
				$content .= '<lastmod>' . $value['lastmod'] . '</lastmod>';
			}
			if(isset($value['changefreq']) && $value['changefreq']) {
				$content .= '<changefreq>' . $value['changefreq'] . '</changefreq>';
			}
			if(isset($value['priority']) && $value['priority']) {
				$content .= '<priority>' . $value['priority'] . '</priority>';
			}
			$content .= '</sitemap>';
		}
		$content .= '</sitemapindex>';
		file_put_contents($filePath, $content);
	}

	/**
	 * Генерирует и записывает сайтмап при включенном разделении файлов
	 * 
	 * @param array $values значения, записываемые в сайтмап
	 * @param string $filePath путь к файлу сайтмапа
	 * @return void
	 */
	private function writeSitemap(array $values, string $filePath): void {
		$content = '<?xml version="1.0" encoding="UTF-8"?>' .
			'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach($values as $value) {
			$content .= '<url>';
			$content .= '<loc>' . $value['url'] . '</loc>';
			if(isset($value['lastmod']) && $value['lastmod']) {
				$content .= '<lastmod>' . $value['lastmod'] . '</lastmod>';
			}
			if(isset($value['changefreq']) && $value['changefreq']) {
				$content .= '<changefreq>' . $value['changefreq'] . '</changefreq>';
			}
			if(isset($value['priority']) && $value['priority']) {
				$content .= '<priority>' . $value['priority'] . '</priority>';
			}
			$content .= '</url>';
		}
		$content .= '</urlset>';
		file_put_contents($filePath, $content);
	}
}