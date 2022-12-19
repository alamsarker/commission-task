<?php

declare(strict_types=1);

namespace App\Client;

use App\Model\Operation;

final class BusinessClient extends AbstractClient
{
    protected function deposit(Operation $operation): float
    {
        return $this->calculate(
            $operation->getAmount(),
            $this->config->get('bussinesDepositRate')
        );
    }

    protected function withdraw(Operation $operation): float
    {
        return $this->calculate(
            $operation->getAmount(),
            $this->config->get('businessWithdrawRate')
        );
    }
}
