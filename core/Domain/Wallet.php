<?php

namespace Core\Domain;

use Core\Domain\Exceptions\InsufficientBalanceException;
use Core\Domain\Exceptions\InvalidValueException;
use DomainException;

class Wallet
{
    public function __construct(
        private float $balance
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->balance < 0) {
            throw new DomainException('Wallet balance must be greater than 0');
        }
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function decrement(float $value): void
    {
        $this->mustBeValidValue($value);
        $this->mustHasBalance($value);
        $this->balance -= $value;
    }

    private function mustBeValidValue(float $value): void
    {
        if ($value < 0) {
            throw new InvalidValueException();
        }
    }

    private function mustHasBalance(float $value): void
    {
        $hasBalance = $this->getBalance() >= $value;
        if (!$hasBalance) {
            throw new InsufficientBalanceException();
        }
    }

    public function increment(float $value): void
    {
        $this->mustBeValidValue($value);
        $this->balance += $value;
    }
}
