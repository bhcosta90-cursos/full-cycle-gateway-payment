<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Account\Data;

class FindByApiKeyInput
{
    public function __construct(public string $apiKey)
    {
        //
    }
}
