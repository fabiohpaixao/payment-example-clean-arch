<?php

namespace Core\Application\Transfer\DataTransfer;

class TransferRequest
{
    public function __construct(
        public string $value,
        public string $payerUuid,
        public string $payeeUuid
    ) {
    }
}
