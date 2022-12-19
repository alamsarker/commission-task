<?php

declare(strict_types=1);

namespace App\FileLoader;

interface FileLoaderInterface
{
    public function load(string $sourcePath): mixed;
}
