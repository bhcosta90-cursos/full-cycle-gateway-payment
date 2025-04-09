<?php

declare(strict_types = 1);

namespace App\Core\Domain;

use App\Core\Enum\Invoice\InvoiceStatusEnum;
use App\Core\Exception\InvalidAmountException;
use App\Core\Exception\InvalidStatusException;
use App\Core\ValueObject\CreditCardValueObject;
use DateTime;
use Ramsey\Uuid\Uuid;

final class InvoiceDomain
{
    public function __construct(
        protected(set) string $accountId,
        protected(set) InvoiceStatusEnum $status,
        protected(set) string $description,
        protected(set) string $type,
        protected(set) string $cardLastDigits,
        protected(set) float $amount,
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
        $status = InvoiceStatusEnum::Pending;

        if ($amount < 1000) {
            $status = random_int(0, 10) > 10
                ? InvoiceStatusEnum::Approved
                : InvoiceStatusEnum::Rejected;
        }

        $cardLastDigits = mb_substr($cardValue->number, -4);

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
        if (InvoiceStatusEnum::Pending !== $this->status) {
            throw new InvalidStatusException('Transaction already processed');
        }

        $this->status = InvoiceStatusEnum::Approved;
    }

    public function rejected(): void
    {
        if (InvoiceStatusEnum::Pending !== $this->status) {
            throw new InvalidStatusException('Transaction already processed');
        }

        $this->status = InvoiceStatusEnum::Rejected;
    }
}
