<?php

declare(strict_types=1);

namespace App\FileLoader;

final class JsonFileLoader implements FileLoaderInterface
{
    private const SUPPORT_EXTENSION = 'json';

    /**
     * @return array
     */
    public function load(string $sourcePath): mixed
    {
        if (!file_exists($sourcePath)) {
            throw new \Exception('File not exists');
        }
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        if ($extension !== self::SUPPORT_EXTENSION) {
            throw new \Exception('Invalid file provided');
        }

        $content = file_get_contents($sourcePath);
        return json_decode($content, true);
    }
}
