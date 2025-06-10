<?php

namespace App\Services\ImageService\Storages;

use App\Services\ImageService\Contracts\StorageContract;

class StandardStorage implements StorageContract
{
	protected static ?StandardStorage $_instance = null;

	protected string $docRoot = '';

	public function __construct()
	{
		$this->docRoot = $_SERVER['DOCUMENT_ROOT'];
	}
	public static function getInstance(): self
	{
		return self::$_instance ??= new self;
	}

	public function path(string $path): string
	{
		return $this->withDocRoot($path);
	}

	public function url(string $path): string
	{
		return $path;
	}

	public function files(string $path, bool $recursive = false, bool $recursiveCall = false): array
	{
		if (!$recursiveCall) {
			$path = $this->withDocRoot($path);
		}

		$files = [];

		if ($handle = opendir($path)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					$file_path = $path . '/' . $entry;

					if (is_file($file_path)) {
						$files[] = $file_path;
					} elseif (is_dir($file_path) && $recursive) {
						$sub_files = $this->files($file_path, true, true);
						$files = array_merge($files, $sub_files);
					}
				}
			}

			closedir($handle);
		}

		return $files;
	}

	public function delete(string $path, $withDocRoot = true): void
	{
		if (!$withDocRoot) {
			$path = $this->withDocRoot($path);
		}

		unlink($path);
	}

	public function exists(string $path): bool
	{
		return file_exists($this->withDocRoot($path));
	}

	public function makeDirectory(string $path): void
	{
		$dir = $this->withDocRoot($path);
		mkdir($dir, 0755, true);
	}

	protected function withDocRoot(string $path): string
	{
		return $this->replaceSlash($this->docRoot . $path);
	}

	protected function replaceSlash($path): string
	{
		return str_replace('//', '/', $path);
	}
}
