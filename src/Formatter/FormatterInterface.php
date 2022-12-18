<?php

declare(strict_types=1);

namespace App\Formatter;

interface FormatterInterface
{
    /**
     * Formatter is used to format the output
     *
     * @param mixed $value
     * @return string
     */
    public function format($value): string;
}
