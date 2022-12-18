<?php

declare(strict_types=1);

namespace App\Factory;

use App\FileLoader\{
    JsonFileLoader,
    CsvFileLoader
};

use App\Command\Console\CommandInterface;
use App\Command\CommissionCalculatorCommand;
use App\Factory\ClientFactory;
use App\HttpClient\HttpClient;
use App\Formatter\RoundedUpFormatter;
use App\CurrencyConverter\BaseCurrencyConverter;

final class CommissionCalculatorCommandFactory
{
    /**
     * Create object of type CommandInterface
     *
     * @return CommandInterface - Return the object of type CommandInterface
     */
    public function create(): CommandInterface
    {
        return new CommissionCalculatorCommand(
            new RoundedUpFormatter(),
            new ClientFactory(),
            new JsonFileLoader(),
            new CsvFileLoader(),
            new HttpClient(),
            new BaseCurrencyConverter()
        );
    }
}
