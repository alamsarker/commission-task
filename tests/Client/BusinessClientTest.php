<?php

declare(strict_types=1);

namespace App\Tests\Client;

use PHPUnit\Framework\TestCase;
use App\Client\BusinessClient;
use App\Model\Operation;
use App\Configuration;

class BusinessClientTest extends TestCase
{
    private BusinessClient $BusinessClient;

    public function setup(): void
    {
        $this->businessClient = new BusinessClient(new Configuration([
            "baseCurrency" => "EUR",
            "bussinesDepositRate" => 1,
            "businessWithdrawRate" => 2,
        ]));
    }

    /**
     *
     * @dataProvider dataProviderForPrivateWithdrawCommission
     */
    public function testWithdrawCommission(Operation $operation, float $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->businessClient->getCommission($operation)
        );
    }

    /**
     *
     * @dataProvider dataProviderForPrivateDepositCommission
     */
    public function testDepositCommission(Operation $operation, float $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->businessClient->getCommission($operation)
        );
    }

    public function dataProviderForPrivateWithdrawCommission(): array
    {
        return [
            'Business withdraw commission of 1200 Euro should be 24' => [ new Operation(new \DateTime('2022-12-17'), 2, 'business', 'withdraw', 1200, 'EUR'), 24 ],
            'Business withdraw commission of 100 Euro should be 2'  => [ new Operation(new \DateTime('2022-12-17'), 1, 'business', 'withdraw', 100, 'EUR'), 2  ],
            'Business withdraw commission of 900 Euro should be 18'  => [ new Operation(new \DateTime('2022-12-17'), 1, 'business', 'withdraw', 900, 'EUR'), 18   ],
            'Business withdraw commission of 200 Euro shoud be 4' => [ new Operation(new \DateTime('2022-12-17'), 1, 'business', 'withdraw', 200, 'EUR'), 4],
            'Business withdraw commission of 100 Euro should be 2' => [ new Operation(new \DateTime('2022-12-17'), 1, 'business', 'withdraw', 100, 'EUR'), 2],
        ];
    }

    public function dataProviderForPrivateDepositCommission(): array
    {
        return [
            'Business deposit commission of 1000 Euro should be 10' => [ new Operation(new \DateTime('2022-12-17'), 2, 'business', 'deposit', 1000, 'EUR'), 10 ],
            'Business deposit commission of 100 Euro should be 1'  => [ new Operation(new \DateTime('2022-12-17'), 1, 'business', 'deposit', 100, 'EUR'), 1   ],
            'Business deposit commission of 900 Euro should be 9'  => [ new Operation(new \DateTime('2022-12-17'), 1, 'business', 'deposit', 900, 'EUR'), 9   ],
            'Business deposit commission of 200 Euro shoud be 2' => [ new Operation(new \DateTime('2022-12-17'), 1, 'business', 'deposit', 200, 'EUR'), 2],
            'Business deposit commission of 100 Euro should be 1' => [ new Operation(new \DateTime('2022-12-17'), 1, 'business', 'deposit', 100, 'EUR'), 1],
        ];
    }
}
