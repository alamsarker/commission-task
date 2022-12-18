<?php

declare(strict_types=1);

namespace App\Command\Console;

final class ConsoleOutput implements OutputInterface
{
    public function writeln(mixed $message): void
    {
        echo sprintf("%s\n", $message);
    }
}
