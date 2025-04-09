<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Account\Data;

readonly class FindByIdInput
{
    public function __construct(public string $id)
    {
        //
    }
}
