<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Invoice\Data;

final readonly class FindByAccountInput
{
    public function __construct(public string $apiKey)
    {
        //
    }
}
