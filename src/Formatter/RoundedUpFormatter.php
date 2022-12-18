<?php

declare(strict_types=1);

namespace App\Formatter;

final class RoundedUpFormatter implements FormatterInterface
{
    private string $currency = '';

    /**
     * Set Currency
     *
     * By Default it does not require to set as its returning always 2 decimal points
     * Exceptions is for JPY currency - as its not supporting cents
     *
     * So its required for JPY currency
     *
     * @param string $currency
     * @return RoundedUpFormatter
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Used to making decimal round
     *
     * @param mixed $value
     * @return string
     */
    public function format($value): string
    {
        if ($this->currency === 'JPY') {
            return number_format(ceil($value), 0, '.', '');
        }

        $mult = pow(10, 2);
        $rounded = ceil($value * $mult) / $mult;

        return number_format((float)$rounded, 2, '.', '');
    }
}
