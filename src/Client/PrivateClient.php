<?php

declare(strict_types=1);

namespace App\Client;

use App\Model\Operation;
use App\Client\CommissionRule\PrivateClientWithdrawRule;
use App\Configuration;

final class PrivateClient extends AbstractClient
{
    private readonly PrivateClientWithdrawRule $withdrawRule;

    public function __construct(
        protected Configuration $config
    ) {
        $this->withdrawRule = new PrivateClientWithdrawRule($config);
        parent::__construct($config);
    }

    protected function deposit(Operation $operation): float
    {
        return $this->calculate(
            $operation->getAmount(),
            $this->config->get('privateDepositRate')
        );
    }

    protected function withdraw(Operation $operation): float
    {
        $this->withdrawRule->onOperation($operation)->apply();

        $rate = $this->withdrawRule->getRate();
        $amount = $this->withdrawRule->getAmount();

        return $this->calculate($amount, $rate);
    }
}
