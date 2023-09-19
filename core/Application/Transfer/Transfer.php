<?php

namespace Core\Application\Transfer;

use Core\Application\Transfer\DataTransfer\TransferRequest;
use Core\Domain\Services\TransferAmountBetweenUsersWallet;
use Core\Domain\User\AbstractUser;
use DomainException;
use Exception;
use Psr\Log\LoggerInterface;

class Transfer
{
    public function __construct(
        private readonly SaveTransactionRepositoryInterface $transactionRepository,
        private readonly GetUserRepositoryInterface $getUserRepository,
        private readonly AuthorizationServiceInterface $authorizationService,
        private readonly NotificationServiceInterface $notificationService,
        private readonly LoggerInterface $logger
    ) {
    }

    public function handle(TransferRequest $transferRequest): void
    {
        try {
            $payer = $this->getUserRepository->handle($transferRequest->payerUuid);
            $payee = $this->getUserRepository->handle($transferRequest->payeeUuid);
            TransferAmountBetweenUsersWallet::handle($payer, $payee, $transferRequest->value);
            $this->authorizationService->handle();
            $this->notificationService->handle($payee->getUuid());
            $this->saveTransaction($payer, $payee, $transferRequest->value);
        } catch (DomainException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->logger->error($e);
            throw $e;
        }
    }

    private function saveTransaction(AbstractUser $payer, AbstractUser $payee, float $value): void
    {
        $this->transactionRepository->handle($payer, $payee, $value);
    }
}
