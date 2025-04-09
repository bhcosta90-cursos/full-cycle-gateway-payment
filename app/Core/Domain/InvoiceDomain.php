<?php

declare(strict_types = 1);

namespace App\Core\Domain;

use App\Core\Enum\Invoice\TransactionStatusEnum;
use App\Core\Exception\InvalidAmountException;
use App\Core\Exception\InvalidStatusException;
use App\Core\ValueObject\CreditCardValueObject;
use DateTime;
use Ramsey\Uuid\Uuid;

class InvoiceDomain
{
    public function __construct(
        public string $accountId,
        public TransactionStatusEnum $status,
        public string $description,
        public string $type,
        public string $cardLastDigits,
        public float $amount,
        protected(set) ?string $id = null,
        protected(set) ?DateTime $createdAt = null,
    ) {
        if (empty($this->id)) {
            $this->id = Uuid::uuid7()->toString();
        }

        if (empty($this->createdAt)) {
            $this->createdAt = new DateTime();
        }

        if ($this->amount <= 0) {
            throw new InvalidAmountException('Amount must be greater than 0');
        }
    }

    public static function create(
        string $accountId,
        string $description,
        string $type,
        CreditCardValueObject $cardValue,
        float $amount,
    ): self {
        $status = TransactionStatusEnum::Pending;

        if($amount < 1000){
            $status = random_int(0,10) > 10
                ? TransactionStatusEnum::Approved
                : TransactionStatusEnum::Rejected;
        }

        $cardLastDigits = substr($cardValue->number, -4);

        return new self(
            accountId: $accountId,
            status: $status,
            description: $description,
            type: $type,
            cardLastDigits: $cardLastDigits,
            amount: $amount,
        );
    }

    public function approved(): void
    {
        if($this->status !== TransactionStatusEnum::Pending){
            throw new InvalidStatusException('Transaction already processed');
        }

        $this->status = TransactionStatusEnum::Approved;
    }

    public function rejected(): void
    {
        if($this->status !== TransactionStatusEnum::Pending){
            throw new InvalidStatusException('Transaction already processed');
        }

        $this->status = TransactionStatusEnum::Rejected;
    }
}
