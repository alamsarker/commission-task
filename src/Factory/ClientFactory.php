<?php

declare(strict_types=1);

namespace App\Factory;

use App\Client\PrivateClient;
use App\Client\BusinessClient;
use App\Client\AbstractClient;
use App\Configuration;
use App\Client\CommissionRule\PrivateClientWithdrawRule;

final class ClientFactory
{
    private static array $cached = [];
    private array $clients = [
        'business' => BusinessClient::class,
        'private' => PrivateClient::class,
    ];

    /**
     * Create the object of type AbstractClient.
     *
     * Client Factory uses cache machanism so that the single object is created for muliple calling
     *
     * @param string $serType - The type of the client - Private or Bussiness
     * @param array $config - The global configuaration
     *
     * @return AbstractClient - Object of Client
     *
     */
    public function create(string $userType, array $config): AbstractClient
    {
        if (empty(self::$cached[$userType])) {
            self::$cached[$userType] = new $this->clients[$userType](new Configuration($config));
        }

        return self::$cached[$userType];
    }
}
