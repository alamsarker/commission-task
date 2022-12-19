<?php

declare(strict_types=1);

namespace App\CurrencyConverter;

final class BaseCurrencyConverter implements CurrencyConverterInterface
{
    public function setRates(array $rates): self
    {
        $this->rates = $rates;

        return $this;
    }

    public function convert(string $from, string $to, float $amount): float
    {
        if ($this->rates['base'] === $to && $amount > 0) {
            return $amount / $this->rates['rates'][$from];
        }

        return $amount;
    }

    public function revert(string $from, string $to, float $amount): float
    {
        if ($this->rates['base'] === $from && $amount > 0) {
            return $amount * $this->rates['rates'][$to];
        }

        return $amount;
    }
}
