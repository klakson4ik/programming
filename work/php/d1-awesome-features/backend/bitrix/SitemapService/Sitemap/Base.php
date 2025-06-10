<?php

namespace App\Services\Sitemap;

use CIBlockElement;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Base
{
	private string|false $timeZone;
	private array|false $iblocks;
	private string $domain;
	private string $path;
	private int|false $fileMaxSize;
	private array $breedingUrls;
	private array $locs = [];
	private array|false $structure;


	public function __construct(string|false $configFile = false)
	{
		$configFile = $configFile ?: __DIR__ . '/config.php';
		if (file_exists($configFile)) {
			$config = require_once $configFile;
			$this->timeZone = $config['timezone'] ?? 'Europe/Moscow';
			$this->iblocks = $config['iblocks'] ?? false;
			$this->domain = $config['domain'] ?? 'https://' . SITE_SERVER_NAME;
			$this->path = $config['path'] ?? $_SERVER['DOCUMENT_ROOT'] . '/';
			$this->fileMaxSize = $config['file-max-size'] ?? false;
			$this->structure = $config['structure'] ?: false;
		} else {
			die('Файл конфигурации не существует');
		}
	}

	public function make(): void
	{
		$this->setTimeZone();
		$this->createSitemaps();
		if ($this->structure) {
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

	private function createSitemaps(): void
	{
		if (!$this->iblocks) {
			return;
		}
		foreach ($this->iblocks as $iblock => $value) {
			$iblock = \Bitrix\Iblock\IblockTable::getList(['filter' => ['CODE' => $iblock]])->fetch();

			if ($iblock) {
				$arElems = CIBlockElement::GetList(arFilter: ['IBLOCK_ID' => $iblock['ID']]);
				$result = [];
				while ($ob = $arElems->GetNextElement()) {
					$fields = $ob->GetFields();
					if ($fields['ACTIVE'] === 'Y') {
						$props = $ob->GetProperties();
						$url = $this->domain . $fields['DETAIL_PAGE_URL'];
						$loc = isset($value['method']) ? $this->domain . $this->locAction($value['method'], $fields, $props) : $url;
						if (!in_array($loc, $this->locs)) {
							$result[] = [
								'loc' => $loc,
								'changefreq' => $value['changefreq'] ?? 'weekly',
								'lastmod' => $value['lastmod'] ?? date('c', $fields['TIMESTAMP_X_UNIX']),
								'priority' => $value['priority'] ?? '0.5'
							];
							$this->locs[] = $loc;
						}
					}
				}
				$fileName = $value['file-name'] ?? $iblock['CODE'];
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

	private function locAction(string $method, array $fields, array $props): string
	{
		$class = 'App\\Services\\Sitemap\\LocAction';
		if (method_exists($class, $method)) {
			return call_user_func([$class, $method], $fields, $props);
		}
	}

	private function createStructure(): void
	{
		$urls = [];
		$dir = '.';
		$dirItr = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
		$filterItr = new FilesFilter($dirItr);
		$iterator = new RecursiveIteratorIterator(
			$filterItr,
			RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ($iterator as $obj) {
			if ($obj->getFilename() === 'index.php') {
				$urls[] = ltrim($obj->getPath(), '.');
			}
		}
		$urls = $filterItr->excludeRegex($urls, $this->structure['exclude']);
		$urls = $this->addCustomUrls($urls);
		$result = array_map(fn ($item) => [
			'loc' => $this->domain . $item . '/',
			'changefreq' => $this->structure['changefreq'] ?? 'weekly',
			'lastmod' => $this->structure['lastmod'] ?? date('c', time()),
			'priority' => $this->structure['priority'] ?? '0.7'
		], $urls);
		$this->createSitemap($result, $this->structure['file-name'] ?? 'structure');
	}

	private function addCustomUrls(array $current): array
	{
		if (!empty($this->structure['include'])) {
			foreach ($this->structure['include'] as $url) {
				$current[] = '/' . $url;
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
