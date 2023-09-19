<?php

namespace Core\Tests\Domain\User;

use Core\Domain\Contact\Email;
use Core\Domain\Document\DocumentInterface;
use Core\Domain\User\Shopkeeper;
use Core\Domain\User\Uuid;
use Core\Domain\Wallet;
use PHPUnit\Framework\TestCase;

class ShopKeeperTest extends TestCase
{
    private DocumentInterface $document;
    private Email $email;
    private Wallet $wallet;

    public function setUp(): void
    {
        $this->document = $this->createMock(DocumentInterface::class);
        $this->email = $this->createMock(Email::class);
        $this->wallet = $this->createMock(Wallet::class);
        $this->uuid = $this->createMock(Uuid::class);
    }

    public function testObjectCreation(): void
    {
        // Arrange
        $name = 'Name Teste';
        $password = 'password';

        // Act
        $shopKeeper = new Shopkeeper(
            $this->uuid,
            $name,
            $this->document,
            $this->email,
            $password,
            $this->wallet
        );

        // Assert
        $this->assertEquals($shopKeeper->getDocument(), $this->document);
        $this->assertEquals($shopKeeper->getEmail(), $this->email);
        $this->assertEquals($shopKeeper->getName(), $name);
        $this->assertEquals($shopKeeper->getUuid(), $this->uuid);
        $this->assertEquals($shopKeeper->getPassword(), $password);
    }

    public function testMustIncrementValueOnWallet()
    {
        // Arrange
        $value = 100;
        $name = 'Name Teste';
        $password = 'password';

        // Assert
        $this->wallet->expects($this->once())
            ->method('increment')
            ->with($value);

        // Act
        $shopKeeper = new Shopkeeper(
            $this->uuid,
            $name,
            $this->document,
            $this->email,
            $password,
            $this->wallet
        );
        $shopKeeper->incrementOnWallet($value);
    }
}
