<?php

declare(strict_types=1);

namespace App\CurrencyConverter;

interface CurrencyConverterInterface
{
    /**
     * Convert currency from one to another
     *
     * @param string $from From Currency like EUR
     * @param string $to converted to this curency
     * @return float
     */
    public function convert(string $from, string $to, float $amount): float;

    /**
    * Revert currency from one to another
    *
    * @param string $from From Currency like EUR
    * @param string $to converted to this curency
    * @return float
    */
    public function revert(string $from, string $to, float $amount): float;
}
