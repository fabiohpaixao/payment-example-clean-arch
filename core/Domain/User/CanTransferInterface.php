<?php

namespace Core\Domain\User;

interface CanTransferInterface
{
    public function decrementFromWallet(float $value): void;
}
