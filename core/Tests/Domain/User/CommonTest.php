<?php

namespace Core\Tests\Domain\User;

use Core\Domain\Contact\Email;
use Core\Domain\Document\DocumentInterface;
use Core\Domain\User\Common;
use Core\Domain\User\Uuid;
use Core\Domain\Wallet;
use PHPUnit\Framework\TestCase;

class CommonTest extends TestCase
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
        $common = new Common(
            $this->uuid,
            $name,
            $this->document,
            $this->email,
            $password,
            $this->wallet
        );

        // Assert
        $this->assertEquals($common->getDocument(), $this->document);
        $this->assertEquals($common->getEmail(), $this->email);
        $this->assertEquals($common->getName(), $name);
        $this->assertEquals($common->getUuid(), $this->uuid);
        $this->assertEquals($common->getPassword(), $password);
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
        $common = new Common(
            $this->uuid,
            $name,
            $this->document,
            $this->email,
            $password,
            $this->wallet
        );
        $common->incrementOnWallet($value);
    }

    public function testMustDecrementValueFromWallet()
    {
        // Arrange
        $value = 100;
        $name = 'Name Teste';
        $password = 'password';

        // Assert
        $this->wallet->expects($this->once())
            ->method('decrement')
            ->with($value);

        // Act
        $common = new Common(
            $this->uuid,
            $name,
            $this->document,
            $this->email,
            $password,
            $this->wallet
        );
        $common->decrementFromWallet($value);
    }
}
