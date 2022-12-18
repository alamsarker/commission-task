<?php

declare(strict_types=1);

namespace App\Command\Console;

interface InputInterface
{
    public function getArg(string $key, mixed $default = ''): mixed;
    public function setArg(string $key, mixed $value): self;
}
