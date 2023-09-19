<?php

namespace Core\Tests\Unit;

use Core\Domain\Exceptions\InsufficientBalanceException;
use Core\Domain\Exceptions\InvalidValueException;
use Core\Domain\Wallet;
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

    public function testItShouldDecrement()
    {
        //Arrange
        $balanceInitial = 100;
        $balanceFinal = 100;
        $decrement = 50;


        //Act
        $wallet = new Wallet($balanceInitial);
        $wallet->decrement($decrement);

        //Assert
        $this->assertEquals($wallet->getBalance(), $balanceFinal);
    }

    public function testItShouldIncrement()
    {
        //Arrange
        $balanceInitial = 100;
        $balanceFinal = 150;
        $increment = 50;


        //Act
        $wallet = new Wallet($balanceInitial);
        $wallet->decrement($increment);

        //Assert
        $this->assertEquals($wallet->getBalance(), $balanceFinal);
    }

    function testItShouldNotDecreaseIfDoNotHaveEnoughBalance()
    {
        //Arrange
        $balanceInitial = 50;
        $decrement = 100;


        //Act
        $wallet = new Wallet($balanceInitial);
        $wallet->decrement($decrement);

        //Assert
        $this->expectException(InsufficientBalanceException::class);
    }

    function testItShouldNotDecreaseIfValueIsLessThanZero()
    {
        //Arrange
        $balanceInitial = 50;
        $decrement = -1;


        //Act
        $wallet = new Wallet($balanceInitial);
        $wallet->decrement($decrement);

        //Assert
        $this->expectException(InvalidValueException::class);
    }

    function testItShouldNotIncrementIfValueIsLessThanZero()
    {
        //Arrange
        $balanceInitial = 50;
        $decrement = -1;


        //Act
        $wallet = new Wallet($balanceInitial);
        $wallet->increment($decrement);

        //Assert
        $this->expectException(InvalidValueException::class);
    }
}
