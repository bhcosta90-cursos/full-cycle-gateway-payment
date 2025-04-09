<?php

declare(strict_types = 1);

namespace App\Core\Domain;

use DateTime;
use Ramsey\Uuid\Uuid;

final class AccountDomain
{
    public function __construct(
        protected(set) string $name,
        protected(set) string $email,
        protected(set) ?string $apiKey = null,
        protected(set) int $balance = 0,
        protected(set) ?string $id = null,
        protected(set) ?DateTime $createdAt = null,
        protected(set) ?DateTime $updatedAt = null,
    ) {
        if (empty($this->apiKey)) {
            $this->apiKey = mb_strtoupper('api_key_' . md5(Uuid::uuid7()->toString()));
        }

        if (empty($this->id)) {
            $this->id = Uuid::uuid7()->toString();
        }

        if (empty($this->createdAt)) {
            $this->createdAt = new DateTime();
        }

        if (empty($this->updatedAt)) {
            $this->updatedAt = new DateTime();
        }
    }

    public function addBalance(float $value): void
    {
        $value = (int) bcmul((string) $value, '100', 0);
        $this->balance += $value;
    }
}
