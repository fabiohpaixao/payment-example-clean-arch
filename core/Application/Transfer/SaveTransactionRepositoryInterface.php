<?php

namespace Core\Application\Transfer;

use Core\Domain\User\AbstractUser;

interface SaveTransactionRepositoryInterface
{
    public function handle(
        AbstractUser $payer,
        AbstractUser $payee,
        float $value
    ): void;
}
