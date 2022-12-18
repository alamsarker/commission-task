<?php

declare(strict_types=1);

namespace App\FileLoader;

interface FileLoaderInterface
{
    /**
     * Load the file and return the content
     *
     * @param string $sourcePath - the source path where the file exists
     * @return mixed - depends on the implemented Child class
     */
    public function load(string $sourcePath): mixed;
}
