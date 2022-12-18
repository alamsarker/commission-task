<?php

declare(strict_types=1);

namespace App\Tests\CurrencyConverter;

use PHPUnit\Framework\TestCase;
use App\CurrencyConverter\BaseCurrencyConverter;

class BaseCurrencyConverterTest extends TestCase
{
    public function testConvertRevert()
    {
        $converter = new BaseCurrencyConverter();
        $converter->setRates([
            'base' => 'EUR',
            'rates' => [
                'USA' => 1,
                'BDT' => 100
            ]
        ]);

        $result = $converter->convert('USA', 'EUR', 1);
        $this->assertEquals(1, $result);

        $revertVale = $converter->revert('EUR', 'USA', $result);
        $this->assertEquals(1, $revertVale);

        $result = $converter->convert('BDT', 'EUR', 100);
        $this->assertEquals(1, $result);

        $revertVale = $converter->revert('EUR', 'BDT', $result);
        $this->assertEquals(100, $revertVale);
    }
}
