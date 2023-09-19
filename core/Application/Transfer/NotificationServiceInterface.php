<?php

namespace Core\Application\Transfer;

interface NotificationServiceInterface
{
    public function handle(string $userUuid): void;
}
