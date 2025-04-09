<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Invoice\Data;

final readonly class CreateInvoiceInput
{
    public function __construct(
        public string $apiKey,
        public float $amount,
        public string $description,
        public string $type,
        public string $cardNumber,
        public string $cardCvv,
        public string $cardHolderName,
        public string $cardExpiredMonth,
        public string $cardExpiredYear,
    ) {
        //
    }
}
