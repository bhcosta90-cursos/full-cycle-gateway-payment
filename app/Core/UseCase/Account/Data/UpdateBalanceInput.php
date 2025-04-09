<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Account\Data;

final readonly class UpdateBalanceInput
{
    public function __construct(public string $apiKey, public float $value)
    {
        //
    }
}
