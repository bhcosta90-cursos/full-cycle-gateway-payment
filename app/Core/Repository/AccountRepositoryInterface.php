<?php

declare(strict_types = 1);

namespace App\Core\Repository;

use App\Core\Domain\AccountDomain;

interface AccountRepositoryInterface
{
    public function create(AccountDomain $accountDomain): AccountDomain;

    public function updateBalance(AccountDomain $accountDomain): AccountDomain;

    public function findByApiKey(string $apiKey): ?AccountDomain;

    public function findById(string $id): ?AccountDomain;
}
