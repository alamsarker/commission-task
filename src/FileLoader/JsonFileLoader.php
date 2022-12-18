<?php

declare(strict_types=1);

namespace App\FileLoader;

final class JsonFileLoader implements FileLoaderInterface
{
    /**
     * Supprted ext is json for JsonFile
     */
    private string $supportExt = 'json';

    /**
     * Load the json file and return the array as content
     *
     * @param string $sourcePath - the path where the json file exists
     * @return array - return array of json file
     */
    public function load(string $sourcePath): mixed
    {
        if (!file_exists($sourcePath)) {
            throw new \Exception('File not exists');
        }
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        if ($extension !== $this->supportExt) {
            throw new \Exception('Invalid file provided');
        }

        $content = file_get_contents($sourcePath);
        return json_decode($content, true);
    }
}
