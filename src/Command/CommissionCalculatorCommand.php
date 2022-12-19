<?php

declare(strict_types=1);

namespace App\Command;

use App\FileLoader\{
    JsonFileLoader,
    CsvFileLoader
};

use App\Command\Console\{
    CommandInterface,
    InputInterface,
    OutputInterface
};

use App\Factory\ClientFactory;
use App\Model\Operation;
use App\HttpClient\HttpClient;
use App\Formatter\RoundedUpFormatter;
use App\CurrencyConverter\BaseCurrencyConverter;

final class CommissionCalculatorCommand implements CommandInterface
{
    public function __construct(
        private RoundedUpFormatter $formatter,
        private ClientFactory $clientFactory,
        private JsonFileLoader $jsonFileLoader,
        private CsvFileLoader $csvFileLoader,
        private HttpClient $httpClient,
        private BaseCurrencyConverter $converter
    ) {
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $config = $this->jsonFileLoader->load(__DIR__ .'/../../config.json');
        $inputData = $this->csvFileLoader->load($input->getArg('param'));
        $exchangeRate = $this->httpClient->sendRequest('GET', $config['currencyExchangeUrl']);

        $this->converter->setRates($exchangeRate);

        foreach ($inputData as $input) {
            $operation = new Operation(
                new \DateTime($input[0]),
                (int)$input[1],
                $input[2],
                $input[3],
                (float)$input[4],
                $input[5]
            );

            $currency = $operation->getCurrency();

            $operation->setAmount(
                $this->converter->convert(
                    $currency,
                    $config['baseCurrency'],
                    $operation->getAmount()
                )
            );

            $commission =  $this->clientFactory->create(
                $operation->getUserType(),
                $config,
                $exchangeRate
            );

            $result = $this->converter->revert(
                $config['baseCurrency'],
                $currency,
                $commission->getCommission($operation)
            );

            $output->writeln($this->formatter->setCurrency($currency)->format($result));
        }
    }
}
