<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Account\Data;

final readonly class AccountOutput
{
    public function __construct(
        public string $id,
        public string $apiKey,
        public string $name,
        public string $email,
        public int $balance,
        public string $createdAt,
        public string $updatedAt,
    ) {
        //
    }
}
