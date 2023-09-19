<?php

namespace Core\Application\Transfer;

use Core\Domain\User\AbstractUser;

interface GetUserRepositoryInterface
{
    public function handle(string $uuid): AbstractUser;
}
