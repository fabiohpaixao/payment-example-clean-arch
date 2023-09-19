<?php

namespace Core\Domain\Services;

use Core\Domain\Exceptions\UserNotAllowedToTransferException;
use Core\Domain\User\AbstractUser;
use Core\Domain\User\CanTransferInterface;

class TransferAmountBetweenUsersWallet
{
    public static function handle(AbstractUser $payer, AbstractUser $payee, float $value): void
    {
        self::mustHasCanTransferImplementation($payer);
        $payer->decrementFromWallet($value);
        $payee->incrementOnWallet($value);
    }

    private static function mustHasCanTransferImplementation(AbstractUser $user): void
    {
        if (!$user instanceof CanTransferInterface) {
            throw new UserNotAllowedToTransferException();
        }
    }
}
