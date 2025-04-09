<?php

declare(strict_types = 1);

namespace App\Core\Repository;

use App\Core\Domain\AccountDomain;

interface AccountRepositoryInterface
{
    public function create(AccountDomain $invoiceDomain): AccountDomain;

    public function updateBalance(AccountDomain $accountDomain, float $value): AccountDomain;

    public function findByApiKey(string $apiKey): ?AccountDomain;

    public function findById(string $id): ?AccountDomain;
}
