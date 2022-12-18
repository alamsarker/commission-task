<?php

declare(strict_types=1);

namespace App\Command\Console;

final class ArgInput implements InputInterface
{
    private array $arg = [];

    public function getArg(string $key, mixed $default = ''): mixed
    {
        if (!empty($this->arg[$key])) {
            return $this->arg[$key];
        }

        return $default;
    }

    public function setArg(string $key, mixed $value): self
    {
        $this->arg[$key] = $value;

        return $this;
    }
}
