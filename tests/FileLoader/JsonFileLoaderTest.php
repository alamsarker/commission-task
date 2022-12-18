<?php

declare(strict_types=1);

namespace App\Tests\FileLoader;

use PHPUnit\Framework\TestCase;
use App\FileLoader\JsonFileLoader;

class JsonFileLoaderTest extends TestCase
{
    private JsonFileLoader $fileLoader;

    public function setup(): void
    {
        $this->fileLoader = new JsonFileLoader();
    }

    /**
     * @dataProvider dataProviderToLoadFile
     */
    public function testLoadException(string $sourcePath, string $expection)
    {
        $this->expectException($expection);
        $this->fileLoader->load($sourcePath);
    }

    public function testLoadSuccess()
    {
        $sourcePath =  __DIR__ .'/../../config.json';
        $data = $this->fileLoader->load($sourcePath);

        $this->assertTrue(is_array($data));
    }

    public function dataProviderToLoadFile(): array
    {
        return [
            'File Not Exist' => [ '../../fileNotExist.csv', \Exception::class],
            'Invalid File' => [ __DIR__ .'/../../input.csv', \Exception::class],
        ];
    }
}
