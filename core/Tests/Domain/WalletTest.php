<?php

namespace Core\Tests\Domain;

use Core\Domain\Exceptions\InsufficientBalanceException;
use Core\Domain\Exceptions\InvalidValueException;
use Core\Domain\Wallet;
use DomainException;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    public function testObjectCreation(): void
    {
        //Arrange
        $balance = 100;

        //Act
        $wallet = new Wallet($balance);

        //Assert
        $this->assertEquals($wallet->getBalance(), $balance);
    }

    public function testMustThrowDomainExceptionWhenTryToCreateObjectWithInvalidBalance()
    {
        // Arrange
        $balance = -10;

        // Assert
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Wallet balance must be greater than 0');

        // Act
        new Wallet($balance);
    }

    public function testItShouldDecrement()
    {
        //Arrange
        $balanceInitial = 100;
        $balanceFinal = 50;
        $decrement = 50;

        //Act
        $wallet = new Wallet($balanceInitial);
        $wallet->decrement($decrement);

        //Assert
        $this->assertEquals($wallet->getBalance(), $balanceFinal);
    }

    function testItShouldNotDecreaseIfValueIsLessThanZero()
    {
        //Arrange
        $balanceInitial = 50;
        $decrement = -1;

        //Assert
        $this->expectException(InvalidValueException::class);

        //Act
        $wallet = new Wallet($balanceInitial);
        $wallet->decrement($decrement);
    }

    function testItShouldNotDecreaseIfDoNotHaveEnoughBalance()
    {
        //Arrange
        $balanceInitial = 50;
        $decrement = 100;

        // Assert
        $this->expectException(InsufficientBalanceException::class);

        //Act
        $wallet = new Wallet($balanceInitial);
        $wallet->decrement($decrement);
    }

    public function testItShouldIncrement()
    {
        //Arrange
        $balanceInitial = 100;
        $balanceFinal = 150;
        $increment = 50;

        //Act
        $wallet = new Wallet($balanceInitial);
        $wallet->increment($increment);

        //Assert
        $this->assertEquals($wallet->getBalance(), $balanceFinal);
    }

    function testItShouldNotIncrementIfValueIsLessThanZero()
    {
        //Arrange
        $balanceInitial = 50;
        $decrement = -1;

        //Assert
        $this->expectException(InvalidValueException::class);

        //Act
        $wallet = new Wallet($balanceInitial);
        $wallet->increment($decrement);
    }
}
