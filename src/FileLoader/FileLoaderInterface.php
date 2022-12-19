<?php

declare(strict_types=1);

namespace App\FileLoader;

interface FileLoaderInterface
{
    /**
     * @return Generator|array
     */
    public function load(string $sourcePath): mixed;
}
