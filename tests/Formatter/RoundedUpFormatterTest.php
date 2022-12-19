<?php

declare(strict_types=1);

namespace App\Tests\Formatter;

use PHPUnit\Framework\TestCase;
use App\Formatter\RoundedUpFormatter;

class RoundedUpFormatterTest extends TestCase
{
    public function testFormat()
    {
        $formatter = new RoundedUpFormatter();

        $result = $formatter->format(0.023);
        $this->assertEquals(0.03, $result);

        $result = $formatter->format(60.591);
        $this->assertEquals(60.60, $result);

        $formatter->setCurrency('JPY');

        $result = $formatter->format(0.00);
        $this->assertEquals(0, $result);

        $result = $formatter->format(11.11);
        $this->assertEquals(12, $result);

        $result = $formatter->format(-320.66);
        $this->assertEquals(-320, $result);
    }
}
