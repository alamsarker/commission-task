<?php

declare(strict_types=1);

namespace App\Client\CommissionRule;

use App\Configuration;
use App\Model\Operation;

class PrivateClientWithdrawRule
{
    private Operation $operation;
    private array $tracker = [];

    public function __construct(private Configuration $config)
    {
    }

    public function onOperation(Operation $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function apply(): void
    {
        if (!$this->operation instanceof Operation) {
            throw new \Exception('onOperation() method is required to call before calling this method.');
        }
        $limitKey = $this->getKey('limit');
        $totalKey = $this->getKey('total');
        $this->tracker[$limitKey] = ($this->tracker[$limitKey] ?? 0) + 1;
        $this->tracker[$totalKey] = ($this->tracker[$totalKey] ?? 0) + $this->operation->getAmount();
    }

    private function getKey(string $key): string
    {
        $weekNumber = $this->operation->getTransDate()->format('oW');
        $userId = $this->operation->getUserId();

        return sprintf('userID-%d-WeekNo-%d-%s', $userId, $weekNumber, $key);
    }

    public function getRate(): float
    {
        $rate = $this->config->get('privateWithdrawRate');
        if ($this->isFreeOfCharge()) {
            $rate = 0;
        }

        return floatval($rate);
    }

    public function getAmount(): float
    {
        $alreadyExceededKey = $this->getKey('AlreadyExceeded');
        $alreadyExceded = $this->tracker[$alreadyExceededKey] ?? 0;
        $weeklyTotal = $this->tracker[$this->getKey('total')] ?? 0;

        $amount = $this->operation->getAmount();

        if (!$alreadyExceded && $this->isExceededMaxAmountPerWeek()) {
            $amount = $weeklyTotal - $this->config->get('privateWithdrawMaxAmount');
            $this->tracker[$alreadyExceededKey] = 1;
        }

        return $amount;
    }


    private function isFreeOfCharge(): bool
    {
        if (
            $this->isInWeekDays()
            && !$this->isExceededMaxAmountPerWeek()
            && !$this->isExceededMaxWithdrawLimitPerWeek()
        ) {
            return true;
        }

        return false;
    }

    private function isInWeekDays(): bool
    {
        $transactAt = $this->operation->getTransDate();
        $startDayOfWeek = (clone $transactAt)->modify(sprintf('%s this week', $this->config->get('startDayOfWeek')));
        $endDayOfWeek = (clone $transactAt)->modify(sprintf('%s this week', $this->config->get('endDayOfWeek')));

        if ($startDayOfWeek <= $transactAt && $transactAt <= $endDayOfWeek) {
            return true;
        }

        return false;
    }

    private function isExceededMaxAmountPerWeek(): bool
    {
        $weeklyTotal = $this->tracker[$this->getKey('total')];
        if ($this->config->get('privateWithdrawMaxAmount') < $weeklyTotal) {
            return true;
        }

        return false;
    }

    private function isExceededMaxWithdrawLimitPerWeek(): bool
    {
        $weeklyLimit = $this->tracker[$this->getKey('limit')];
        if ($this->config->get('privateWithdrawWeeklyLimit') < $weeklyLimit) {
            return true;
        }

        return false;
    }
}
