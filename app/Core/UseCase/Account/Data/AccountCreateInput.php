<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Account\Data;

readonly class AccountCreateInput
{
    public function __construct(public string $name, public string $email)
    {
        //
    }
}
