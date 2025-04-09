<?php

declare(strict_types = 1);

namespace App\Core\Repository;

use App\Core\Domain\InvoiceDomain;

interface InvoiceRepositoryInterface
{
    public function create(InvoiceDomain $invoiceDomain): InvoiceDomain;

    public function updateStatus(InvoiceDomain $invoiceDomain): InvoiceDomain;

    /**
     * @return InvoiceDomain[]
     */
    public function findByAccountId(string $accountId): array;

    public function findById(string $id): ?InvoiceDomain;
}
