<?php

declare(strict_types = 1);

namespace App\Core\Enum\Invoice;

enum TransactionStatusEnum: int
{
    case Pending  = 1;
    case Approved = 2;
    case Rejected = 3;
}
