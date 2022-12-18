<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Client\AbstractClient;
use App\Client\PrivateClient;
use App\Client\BusinessClient;
use App\Factory\ClientFactory;

class ClientFactoryTest extends TestCase
{
    private ClientFactory $clientFactory;

    public function setup(): void
    {
        $this->clientFactory = new ClientFactory();
    }

    /**
     * @dataProvider dataProviderClientObject
     */
    public function testCreate(string $userType, $config, string $expection)
    {
        $client = $this->clientFactory->create($userType, $config);
        $this->assertTrue($client instanceof $expection);
    }


    public function dataProviderClientObject(): array
    {
        return [
            'BuinessClient' => [ 'business', [], AbstractClient::class ],
            'PrivateClient' => [ 'private', [], AbstractClient::class],
        ];
    }
}
