<?php

namespace Core\Tests\Unit;

use Core\Application\Transfer\GetUserRepositoryInterface;
use Core\Domain\Contact\Email;
use Core\Domain\Document\DocumentInterface;
use Core\Domain\User\Common;
use Core\Domain\User\Shopkeeper;
use Core\Domain\User\Uuid;
use Core\Domain\Wallet;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class TransferTest extends TestCase
{
    private LoggerInterface $logger;
    private DocumentInterface $documentDummy;
    private Email $emailDummy;
    private Common $userCommonDummy;


    public function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->documentDummy = $this->createMock(DocumentInterface::class);
        $this->emailDummy = $this->createMock(Email::class);
        $this->userCommonDummy = $this->createMock(Common::class);
    }

    public function testMustBeTransfer(): void
    {
        //Arrange
        $getUserRepository = $this->createMock(GetUserRepositoryInterface::class)
            ->expects($this->exactly(2))
            ->willReturnOnConsecutiveCalls($this->userCommonDummy, $this->userCommonDummy);
    }

    public function testMustBeTransferFromCommonToShopper():void
    {
        //Arrange

        $payer = new Common(
            new Uuid('ID-123'),
            'Name',
            $this->documentDummy,
            $this->emailDummy,
            'password',
            new Wallet(100)
        );
        $payee = new Shopkeeper(
            new Uuid('ID-123'),
            'Name',
            $this->documentDummy,
            $this->emailDummy,
            'password',
            new Wallet(100)
        );
        $getUserRepository = $this->createMock(GetUserRepositoryInterface::class)
            ->expects($this->exactly(2))
            ->willReturnOnConsecutiveCalls($payer, $payee);

        //private readonly GetUserRepositoryInterface $getUserRepository,
       // private readonly AuthorizationServiceInterface $authorizationService,
      //  private readonly NotificationServiceInterface $notificationService,

        //Act


        //Assert
        $this->assertTrue(true);
    }

}
