<?php

namespace Core\Domain\User;

use Core\Domain\Contact\Email;
use Core\Domain\Document\DocumentInterface;
use Core\Domain\Wallet;

abstract class AbstractUser implements CanReceiveInterface
{
    public function __construct(
        protected Uuid $uuid,
        protected string $name,
        protected DocumentInterface $document,
        protected Email $email,
        protected string $password,
        protected Wallet $wallet
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDocument(): DocumentInterface
    {
        return $this->document;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function incrementOnWallet(float $value): void
    {
        $this->wallet->increment($value);
    }
}
