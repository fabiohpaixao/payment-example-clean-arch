<?php

namespace Core\Tests\Unit;

use Core\Domain\Contact\Email;
use Core\Domain\Document\DocumentInterface;
use Core\Domain\Exceptions\InvalidValueException;
use Core\Domain\User\Shopkeeper;
use Core\Domain\User\Uuid;
use Core\Domain\Wallet;
use DomainException;
use PHPUnit\Framework\TestCase;

class ShopKeeperTest extends TestCase
{
    private DocumentInterface $documentDummy;
    private Email $emailDummy;
    private Wallet $walletDummy;

    public function setUp(): void
    {
        $this->documentDummy = $this->createMock(DocumentInterface::class);
        $this->emailDummy = $this->createMock(Email::class);
        $this->walletDummy = $this->createMock(Wallet::class);
        $this->uuidDummy = $this->createMock(Uuid::class);
    }

    public function testObjectCreation(): void
    {
        //Arrange
        $name = 'Name Teste';
        $password = 'password';

        //Act
        $shopKeeper = new Shopkeeper(
            $this->uuidDummy,
            $name,
            $this->documentDummy,
            $this->emailDummy,
            $password,
            $this->walletDummy
        );

        //Assert
        $this->assertEquals($shopKeeper->getDocument(), $this->documentDummy);
        $this->assertEquals($shopKeeper->getEmail(), $this->emailDummy);
        $this->assertEquals($shopKeeper->getName(), $name);
        $this->assertEquals($shopKeeper->getUuid(), $this->uuidDummy);
        $this->assertEquals($shopKeeper->getPassword(), $password);
    }

    public function testIncrementOnWalletInvalidValueException()
    {
        //Arrange
        $name = 'Name Teste';
        $password = 'password';
        $walletMock = $this->createMock(Wallet::class);
        $walletMock->method('increment')
            ->willThrowException(new InvalidValueException());

        $shopKeeper = new Shopkeeper(
            $this->uuidDummy,
            $name,
            $this->documentDummy,
            $this->emailDummy,
            $password,
            $walletMock
        );

        //Assert
        $this->expectException(DomainException::class);

        //Act
        $shopKeeper->incrementOnWallet(10);
    }
}
