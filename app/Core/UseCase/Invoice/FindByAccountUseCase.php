<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Invoice;

use App\Core\Domain\InvoiceDomain;
use App\Core\Repository\InvoiceRepositoryInterface;
use App\Core\UseCase\Invoice\Data\FindByAccountInput;
use App\Core\UseCase\Invoice\Data\InvoiceOutput;

final readonly class FindByAccountUseCase
{
    public function __construct(
        protected InvoiceRepositoryInterface $invoiceRepository,
    ) {
        //
    }

    /**
     * @return InvoiceOutput[]
     */
    public function handle(FindByAccountInput $input): array
    {
        return array_map(
            fn (InvoiceDomain $invoiceDomain) => new InvoiceOutput(
                id: $invoiceDomain->id,
                accountId: $invoiceDomain->accountId,
                amount: $invoiceDomain->amount,
                status: $invoiceDomain->status->label(),
                type: $invoiceDomain->type,
                cardLastDigits: $invoiceDomain->cardLastDigits,
                createdAt: $invoiceDomain->createdAt->format('Y-m-d H:i:s'),
            ),
            $this->invoiceRepository->findByAccountId($input->apiKey),
        );
    }
}
