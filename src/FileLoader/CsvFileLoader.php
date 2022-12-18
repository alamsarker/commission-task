<?php

declare(strict_types=1);

namespace App\FileLoader;

final class CsvFileLoader implements FileLoaderInterface
{
    /**
     * Supporting ext csv for CSV file
     */
    private string $supportExt = 'csv';

    /**
     * The max length of the row of the csv file
     */
    private int $length = 4096;

    /**
     * This csv file is supported the comma(,) separated content
     */
    private string $delimiter = ',';

    /**
     * load method returning the Generator
     * @param string $sourcePath - the path of the csv file
     * @return Generator
     */
    public function load(string $sourcePath): mixed
    {
        if (!file_exists($sourcePath)) {
            throw new \Exception('File not exists');
        }
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        if ($extension !== $this->supportExt) {
            throw new \Exception('File is not supported with this extension');
        }

        $handle = fopen($sourcePath, "r");

        if (!$handle) {
            throw new \Exception('The file can not be opened');
        }

        if (($handle = fopen($sourcePath, "r")) !== false) {
            while (($row = fgetcsv($handle, $this->length, $this->delimiter)) !== false) {
                if (is_array($row) && count($row) > 0) {
                    yield $row;
                }
            }
            fclose($handle);
        }
    }
}
