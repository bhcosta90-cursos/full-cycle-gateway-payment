<?php

declare(strict_types = 1);

namespace App\Core\ValueObject;

readonly class CreditCardValueObject
{
    public function __construct(
        protected(set) string $number,
        protected(set) string $cvv,
        protected(set) string $holderName,
        protected(set) string $expiredYear,
        protected(set) string $expiredMonth,
    ) {
        //
    }
}
