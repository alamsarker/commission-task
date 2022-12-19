<?php

declare(strict_types=1);

namespace App\Model;

class Operation
{
    public function __construct(
        private \DateTime $transDate,
        private int $userId,
        private string $userType,
        private string $operationType,
        private float $amount,
        private string $currency,
    ) {
    }

    public function setTransDate($transDate): self
    {
        $this->transDate = $transDate;

        return $this;
    }

    public function getTransDate(): \DateTime
    {
        return $this->transDate;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserType(string $userType): self
    {
        $this->userType = $userType;

        return $this;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }

    public function setOperationType(string $operationType): self
    {
        $this->operationType = $operationType;

        return $this;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
