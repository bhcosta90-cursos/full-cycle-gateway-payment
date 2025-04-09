<?php

declare(strict_types = 1);

namespace App\Core\Enum\Invoice;

enum InvoiceStatusEnum: int
{
    case Pending  = 1;
    case Approved = 2;
    case Rejected = 3;

    public function label(): string
    {
        return match ($this) {
            self::Pending  => 'pending',
            self::Approved => 'approved',
            self::Rejected => 'rejected',
        };
    }
}
