<?php

namespace Core\Domain\User;

class Uuid
{
    public function __construct(
        private string $uuid
    ) {
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
