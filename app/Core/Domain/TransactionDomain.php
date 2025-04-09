<?php

declare(strict_types = 1);

namespace App\Core\Domain;

use App\Core\Enum\Invoice\TransactionStatusEnum;
use App\Core\Exception\InvalidAmountException;
use App\Core\ValueObject\CreditCardValueObject;
use DateTime;
use Ramsey\Uuid\Uuid;

class TransactionDomain
{
    protected function __construct(
        public string $apiKey,
        public TransactionStatusEnum $status,
        public string $description,
        public string $type,
        public string $cardLastDigits,
        public float $amount,
        protected(set) ?string $id = null,
        protected(set) ?DateTime $createdAt = null,
        protected(set) ?DateTime $updatedAt = null,
    ) {
        if (empty($this->id)) {
            $this->id = Uuid::uuid7()->toString();
        }

        if (empty($this->createdAt)) {
            $this->createdAt = new DateTime();
        }

        if (empty($this->updatedAt)) {
            $this->updatedAt = new DateTime();
        }

        if ($this->amount <= 0) {
            throw new InvalidAmountException('Amount must be greater than 0');
        }
    }

    public static function create(
        string $apiKey,
        TransactionStatusEnum $status,
        string $description,
        string $type,
        CreditCardValueObject $cardValue,
        float $amount,
    ): self {

        $cardLastDigits = substr($cardValue->number, -4);

        return new self(
            apiKey: $apiKey,
            status: $status,
            description: $description,
            type: $type,
            cardLastDigits: $cardLastDigits,
            amount: $amount,
        );
    }
}
