<?php

namespace Core\Tests\Application\Transfer;

use Core\Application\Transfer\AuthorizationServiceInterface;
use Core\Application\Transfer\DataTransfer\TransferRequest;
use Core\Application\Transfer\GetUserRepositoryInterface;
use Core\Application\Transfer\NotificationServiceInterface;
use Core\Application\Transfer\SaveTransactionRepositoryInterface;
use Core\Application\Transfer\Transfer;
use Core\Domain\User\Common;
use Core\Domain\User\Shopkeeper;
use Core\Domain\User\Uuid;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class TransferTest extends TestCase
{
    private LoggerInterface $logger;

    public function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
    }

    public function testMustTransferValueBetweenUsers()
    {
        // Arrange
        $transferRequest = new TransferRequest(100, uniqid(), uniqid());

        // Assert
        $payer = $this->createMock(Common::class);
        $payer->expects($this->once())
            ->method('decrementFromWallet')
            ->with($transferRequest->value);

        $payeeUuid = $this->createMock(Uuid::class);
        $payeeUuid->method('__toString')
            ->willReturn($transferRequest->payeeUuid);

        $payee = $this->createMock(Shopkeeper::class);
        $payee->method('getUuid')
            ->willReturn($payeeUuid);
        $payee->expects($this->once())
            ->method('incrementOnWallet')
            ->with($transferRequest->value);

        $getUserRepository = $this->createMock(GetUserRepositoryInterface::class);
        $getUserRepository->expects($this->exactly(2))
            ->method('handle')
            ->willReturnOnConsecutiveCalls($payer, $payee);

        $authorizationService = $this->createMock(AuthorizationServiceInterface::class);
        $authorizationService->expects($this->once())
            ->method('handle');

        $notificationService = $this->createMock(NotificationServiceInterface::class);
        $notificationService->expects($this->once())
            ->method('handle')
            ->with($payee->getUuid());

        $transactionRepository = $this->createMock(SaveTransactionRepositoryInterface::class);
        $transactionRepository->expects($this->once())
            ->method('handle')
            ->with($payer, $payee, $transferRequest->value);

        // Act
        $transferUseCase = new Transfer(
            $transactionRepository,
            $getUserRepository,
            $authorizationService,
            $notificationService,
            $this->logger
        );
        $transferUseCase->handle($transferRequest);
    }
}
