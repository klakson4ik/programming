<?php

namespace App\Services\Sitemap;

use RecursiveFilterIterator;
use RecursiveIterator;

class FilesFilter extends RecursiveFilterIterator
{
	private array $exclude = ['bitrix', 'local', 'logs', 'images', 'upload',];

	public function __construct(RecursiveIterator $recursiveIter)
	{
		parent::__construct($recursiveIter);
	}

	public function accept(): bool
	{
		return !in_array(
			$this->current()->getFilename(),
			$this->exclude,
			true
		);
	}

	public function excludeRegex(array $items, array $excludes): array
	{
		$result = [];
		foreach ($items as $item) {
			$isExclude = false;
			foreach ($excludes as $exclude) {
				if (preg_match('/\b(?<!-)' . str_replace('/', '\/', $exclude) . '(?!-)\b/', $item)) {
					$isExclude = true;
					break;
				}
			}
			if (!$isExclude) {
				$result[] = $item;
			}
		}

		return $result;
	}
}
