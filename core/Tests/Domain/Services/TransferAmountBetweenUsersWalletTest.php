<?php

namespace Core\Tests\Domain\Services;

use Core\Domain\Exceptions\UserNotAllowedToTransferException;
use Core\Domain\Services\TransferAmountBetweenUsersWallet;
use Core\Domain\User\Common;
use Core\Domain\User\Shopkeeper;
use PHPUnit\Framework\TestCase;

class TransferAmountBetweenUsersWalletTest extends TestCase
{
    public function testMustTransferValueBetweenUsersWallet()
    {
        // Arrange
        $value = 100;

        // Assert
        $payer = $this->createMock(Common::class);
        $payer->expects($this->once())
            ->method('decrementFromWallet');

        $payee = $this->createMock(Common::class);
        $payee->expects($this->once())
            ->method('incrementOnWallet');

        // Act
        TransferAmountBetweenUsersWallet::handle($payer, $payee, $value);
    }

    public function testMustByThrowUserNotAllowedToTransferException()
    {
        // Arrange
        $value = 100;
        $payer = $this->createMock(Shopkeeper::class);
        $payee = $this->createMock(Common::class);

        // Assert
        $this->expectException(UserNotAllowedToTransferException::class);

        // Act
        TransferAmountBetweenUsersWallet::handle($payer, $payee, $value);
    }
}
