<?php

declare(strict_types=1);

namespace App\Client\CommissionRule;

use App\Configuration;
use App\Model\Operation;

class PrivateClientWithdrawRule
{
    /**
     * Input Operation
     */
    private Operation $operation;

    /**
     * tracking the previous data for free eligibility calculation
     */
    private array $tracker = [];

    /**
     * Constructor
     *
     * @param Configuration $config
     */
    public function __construct(private Configuration $config)
    {
    }

    /**
     * Apply the rule based on the Operation
     */
    public function onOperation(Operation $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Apply is preparing the configuration to get ready to calling getRate() and getAmount() method
     *
     * @return void
     */
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

    /**
     * Get commission rate
     * If free eligible then return the rate is 0
     * Otherwise returing rate from config
     *
     * @return float - percentage of commission rate
     */
    public function getRate(): float
    {
        $rate = $this->config->get('privateWithdrawRate');
        if ($this->isFreeOfCharge()) {
            $rate = 0;
        }

        return floatval($rate);
    }

    /**
     * Get the amount based on the eligibility checking
     *
     * @return float - the amount after calculating the free rule checking
     */
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

    /**
     * Checking free of commission
     */
    private function isFreeOfCharge(): bool
    {
        if (
            $this->isInWeekDays() &&
            !$this->isExceededMaxAmountPerWeek() &&
            !$this->isExceededMaxWithdrawLimitPerWeek()
        ) {
            return true;
        }

        return false;
    }

    /**
     * Checking the operations happens on weekday for free eligibility
     *
     * @return bool
     */
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

    /**
     * Checking the max amount weekly for free eligibilty
     *
     * @return bool
     */
    private function isExceededMaxAmountPerWeek(): bool
    {
        $weeklyTotal = $this->tracker[$this->getKey('total')];
        if ($this->config->get('privateWithdrawMaxAmount') < $weeklyTotal) {
            return true;
        }

        return false;
    }

    /**
     * Checking the max times of limit weekly
     *
     * @return bool - if exceeded then true otherwise false
     */
    private function isExceededMaxWithdrawLimitPerWeek(): bool
    {
        $weeklyLimit = $this->tracker[$this->getKey('limit')];
        if ($this->config->get('privateWithdrawWeeklyLimit') < $weeklyLimit) {
            return true;
        }

        return false;
    }
}
