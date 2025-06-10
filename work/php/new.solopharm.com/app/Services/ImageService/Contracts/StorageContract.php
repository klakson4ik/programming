<?php

namespace App\Services\ImageService\Contracts;

interface StorageContract
{
	public function path(string $path): string;

	public function url(string $path): string;

	public function files(string $path, bool $recursive): array;

	public function delete(string $path): void;

	public function exists(string $path): bool;

	public function makeDirectory(string $path): void;
}
