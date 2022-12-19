<?php

declare(strict_types=1);

namespace App\Client;

use App\Configuration;
use App\Model\Operation;
use App\Enum\OperationType;

abstract class AbstractClient
{
    public function __construct(
        protected Configuration $config
    ) {
    }

    /**
     * Calculate commission based on the rate and amount.
     *
     * @param float $amount - Commission will be calculated on the amount
     * @param float $rate - Parcentage of the rate
     *
     * @return float Commissio will be return as float
     */
    protected function calculate(float $amount, float $rate): float
    {
        $comission = 0;
        if ($amount > 0 && $rate > 0) {
            $comission = ($rate * $amount) / 100;
        }

        return floatval($comission);
    }

    /**
     * Forwarding the client based on the input operation type
     *
     * @param Operation $operation - The input as Opration Model
     * @return float - return the final commission
     */
    public function getCommission(Operation $operation): float
    {
        $commission = match ($operation->getOperationType()) {
            OperationType::Deposit->value => $this->deposit($operation),
            OperationType::Withdraw->value => $this->withdraw($operation),
            default => throw new \Exception('Invalid OperationType Provided')
        };

        return floatval($commission);
    }


    abstract protected function deposit(Operation $operation): float;
    abstract protected function withdraw(Operation $operation): float;
}
