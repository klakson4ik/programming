<?php

declare(strict_types=1);

namespace App\Service;

final readonly class FilesService
{
    public function __construct(
        public string $dir
    ) {
    }

    public function saveContent(string $path, string $content): false|int
    {
        return file_put_contents($this->dir.$path, $content);
    }

    public function getLastFile(string $dir, ?callable $filter = null): ?\DirectoryIterator
    {
        $dir = $this->dir.$dir;
        $file = null;

        foreach (new \DirectoryIterator($dir) as $item) {
            /** @var \DirectoryIterator $item */
            if (!$item->isFile()) {
                continue;
            }

            if (!empty($file) && $item->getMTime() <= $file->getMTime()) {
                continue;
            }

            if (is_callable($filter) && !$filter($item)) {
                continue;
            }

            $file = clone $item;
        }

        return $file;
    }
}
