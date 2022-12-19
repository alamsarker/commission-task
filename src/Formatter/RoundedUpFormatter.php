<?php

declare(strict_types=1);

namespace App\Formatter;

final class RoundedUpFormatter implements FormatterInterface
{
    private string $currency = '';

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function format(float $value): string
    {
        if ($this->currency === 'JPY') {
            return number_format(ceil($value), 0, '.', '');
        }

        $mult = pow(10, 2);
        $rounded = ceil($value * $mult) / $mult;

        return number_format((float)$rounded, 2, '.', '');
    }
}
