<?php

declare(strict_types=1);

namespace App\Tests\FileLoader;

use PHPUnit\Framework\TestCase;
use App\FileLoader\CsvFileLoader;

class CsvFileLoaderTest extends TestCase
{
    private CsvFileLoader $fileLoader;

    public function setup(): void
    {
        $this->fileLoader = new CsvFileLoader();
    }

    /**
     * @dataProvider dataProviderToLoadFile
     */
    public function testLoadException(string $sourcePath, string $expection)
    {
        $this->expectException($expection);
        $data = $this->fileLoader->load($sourcePath);
        foreach ($data as $d) {
            $this->assertIsObject(new \DateTime($d[0]));
        }
    }

    public function testLoadSuccess()
    {
        $sourcePath =  __DIR__ .'/../../input.csv';
        $data = $this->fileLoader->load($sourcePath);

        foreach ($data as $d) {
            $this->assertIsObject(new \DateTime($d[0]));
        }
    }

    public function dataProviderToLoadFile(): array
    {
        return [
            'File Not Exist' => [ '../../fileNotExist.csv', \Exception::class],
            'Invalid File' => [ __DIR__ .'/../../config.json', \Exception::class],
        ];
    }
}
