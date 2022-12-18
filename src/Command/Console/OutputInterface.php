<?php

declare(strict_types=1);

namespace App\Command\Console;

interface OutputInterface
{
    public function writeln(string $message): void;
}
