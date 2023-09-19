<?php

namespace Core\Domain\User;

class Common extends AbstractUser implements CanTransferInterface
{
    public function decrementFromWallet(float $value): void
    {
        $this->wallet->decrement($value);
    }
}
