<?php

declare(strict_types=1);

namespace App\FileLoader;

final class CsvFileLoader implements FileLoaderInterface
{
    private const SUPPORT_EXTENSION = 'csv';
    private const LENGTH = 4096;
    private const DELIMITER = ',';

    public function load(string $sourcePath): mixed
    {
        if (!file_exists($sourcePath)) {
            throw new \Exception('File not exists');
        }
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        if ($extension !== self::SUPPORT_EXTENSION) {
            throw new \Exception('File is not supported with this extension');
        }

        $handle = fopen($sourcePath, "r");

        if (!$handle) {
            throw new \Exception('The file can not be opened');
        }

        if (($handle = fopen($sourcePath, "r")) !== false) {
            while (($row = fgetcsv($handle, self::LENGTH, self::DELIMITER)) !== false) {
                if (is_array($row) && count($row) > 0) {
                    yield $row;
                }
            }
            fclose($handle);
        }
    }
}
