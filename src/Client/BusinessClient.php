<?php

declare(strict_types=1);

namespace App\Client;

use App\Model\Operation;

final class BusinessClient extends AbstractClient
{
    /**
     * Caculate deposit commission for Business Client
     *
     * @param Operation @operation - The input
     */
    protected function deposit(Operation $operation): float
    {
        return $this->calculate(
            $operation->getAmount(),
            $this->config->get('bussinesDepositRate')
        );
    }

    /**
     * Calcuate withdraw commission for Bussines Client
     *
     * @param Operation $operation - The input
     */
    protected function withdraw(Operation $operation): float
    {
        return $this->calculate(
            $operation->getAmount(),
            $this->config->get('businessWithdrawRate')
        );
    }
}
