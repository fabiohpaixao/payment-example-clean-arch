<?php

namespace Core\Application\Transfer;

use Core\Domain\Exceptions\TransactionNotAuthorizedException;

interface AuthorizationServiceInterface
{
    /** @throws TransactionNotAuthorizedException */
    public function handle(): void;
}
