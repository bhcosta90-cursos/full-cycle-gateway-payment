<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Invoice\Data;

final readonly class InvoiceOutput
{
    public function __construct(
        public string $id,
        public string $accountId,
        public float $amount,
        public string $status,
        public string $type,
        public string $cardLastDigits,
        public string $createdAt,
    ) {
        //
    }
}
