<?php

declare(strict_types=1);

namespace App\CurrencyConverter;

interface CurrencyConverterInterface
{
    public function convert(string $from, string $to, float $amount): float;
    public function revert(string $from, string $to, float $amount): float;
}
