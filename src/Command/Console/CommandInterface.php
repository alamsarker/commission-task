<?php

declare(strict_types=1);

namespace App\Command\Console;

interface CommandInterface
{
    public function run(InputInterface $input, OutputInterface $output): void;
}
