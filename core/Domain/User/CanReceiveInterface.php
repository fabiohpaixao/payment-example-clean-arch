<?php

namespace Core\Domain\User;

interface CanReceiveInterface
{
    public function incrementOnWallet(float $value): void;
}
