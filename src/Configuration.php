<?php

declare(strict_types=1);

namespace App;

final class Configuration
{
    public function __construct(private array $config)
    {
    }

    public function get(string $key, mixed $defatult =''): mixed
    {
        if (!empty($this->config[$key])) {
            return $this->config[$key];
        }

        return $defatult;
    }
}
