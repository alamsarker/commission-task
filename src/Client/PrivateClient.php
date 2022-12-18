<?php

declare(strict_types=1);

namespace App\Client;

use App\Model\Operation;
use App\Client\CommissionRule\PrivateClientWithdrawRule;
use App\Configuration;

final class PrivateClient extends AbstractClient
{
    private readonly PrivateClientWithdrawRule $withdrawRule;

    /**
     * Constructor
     *
     * Overriden the Parent constructor, as its been composed of PrivderWithdrawRule
     *
     * @param Configuration $config - The global config comes from config.json file
     */
    public function __construct(
        protected Configuration $config
    ) {
        $this->withdrawRule = new PrivateClientWithdrawRule($config);
        parent::__construct($config);
    }

    /**
     * Calculate deposit commission for Private Client
     *
     * @param Operation $operation - The input
     * @return float - deposit commission will be returned
     */
    protected function deposit(Operation $operation): float
    {
        return $this->calculate(
            $operation->getAmount(),
            $this->config->get('privateDepositRate')
        );
    }

    /**
     * Calculate withdraw commission for Private Client
     *
     * @param Operation $operation - The input
     * @return float - withdraw commission will be returned
     */
    protected function withdraw(Operation $operation): float
    {
        $this->withdrawRule->onOperation($operation)->apply();

        $rate = $this->withdrawRule->getRate();
        $amount = $this->withdrawRule->getAmount();

        return $this->calculate($amount, $rate);
    }
}
