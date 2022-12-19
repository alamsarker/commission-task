<?php

declare(strict_types=1);

namespace App\Tests\Client;

use PHPUnit\Framework\TestCase;
use App\Client\PrivateClient;
use App\Model\Operation;
use App\Configuration;

class PrivateClientTest extends TestCase
{
    private static PrivateClient $privateClient;

    public static function setUpBeforeClass(): void
    {
        self::$privateClient = new PrivateClient(new Configuration([
            "baseCurrency" => "EUR",
            "privateDepositRate" => 10,
            "privateWithdrawRate" => 10,
            "privateWithdrawMaxAmount" => 1000,
            "privateWithdrawWeeklyLimit" => 3,
            "startDayOfWeek" => "Monday",
            "endDayOfWeek" => "Sunday",
        ]));
    }

    /**
     * @dataProvider dataProviderForPrivateWithdrawCommission
     */
    public function testWithdrawCommission(Operation $operation, float $expectation)
    {
        $this->assertEquals(
            $expectation,
            self::$privateClient->getCommission($operation)
        );
    }

    /**
     * @dataProvider dataProviderForPrivateDepositCommission
     */
    public function testDepositCommission(Operation $operation, float $expectation)
    {
        $this->assertEquals(
            $expectation,
            self::$privateClient->getCommission($operation)
        );
    }

    public function dataProviderForPrivateWithdrawCommission(): array
    {
        return [
            'Private withdraw commission of 1200 Euro should be 20' => [ new Operation(new \DateTime('2022-12-17'), 2, 'private', 'withdraw', 1200, 'EUR'), 20 ],
            'Private withdraw commission of 100 Euro should be 0'  => [ new Operation(new \DateTime('2022-12-17'), 1, 'private', 'withdraw', 100, 'EUR'), 0   ],
            'Private withdraw commission of 900 Euro should be 0'  => [ new Operation(new \DateTime('2022-12-17'), 1, 'private', 'withdraw', 900, 'EUR'), 0   ],
            'Private withdraw commission of 200 Euro shoud be 10' => [ new Operation(new \DateTime('2022-12-17'), 1, 'private', 'withdraw', 200, 'EUR'), 20],
            'Private withdraw commission of 100 Euro should be 1s0' => [ new Operation(new \DateTime('2022-12-17'), 1, 'private', 'withdraw', 100, 'EUR'), 10],
        ];
    }

    public function dataProviderForPrivateDepositCommission(): array
    {
        return [
            'Private deposit commission of 1000 Euro should be 100' => [ new Operation(new \DateTime('2022-12-17'), 2, 'private', 'withdraw', 1000, 'EUR'), 100 ],
            'Private deposit commission of 100 Euro should be 10'  => [ new Operation(new \DateTime('2022-12-17'), 1, 'private', 'withdraw', 100, 'EUR'), 10   ],
            'Private deposit commission of 900 Euro should be 90'  => [ new Operation(new \DateTime('2022-12-17'), 1, 'private', 'withdraw', 900, 'EUR'), 90   ],
            'Private deposit commission of 200 Euro shoud be 20' => [ new Operation(new \DateTime('2022-12-17'), 1, 'private', 'withdraw', 200, 'EUR'), 20],
            'Private deposit commission of 100 Euro should be 10' => [ new Operation(new \DateTime('2022-12-17'), 1, 'private', 'withdraw', 100, 'EUR'), 10],
        ];
    }
}
