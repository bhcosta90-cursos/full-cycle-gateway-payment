<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Invoice\Data;

final readonly class FindByIdInput
{
    public function __construct(public string $id, public string $apiKey)
    {
        //
    }
}
