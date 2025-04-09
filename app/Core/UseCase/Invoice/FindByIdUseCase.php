<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Invoice;

use App\Core\Exception\NotFoundException;
use App\Core\Repository\AccountRepositoryInterface;
use App\Core\Repository\InvoiceRepositoryInterface;
use App\Core\UseCase\Invoice\Data\FindByAccountInput;
use App\Core\UseCase\Invoice\Data\InvoiceOutput;

final readonly class FindByIdUseCase
{
    public function __construct(
        protected AccountRepositoryInterface $accountRepository,
        protected InvoiceRepositoryInterface $invoiceRepository,
    ) {
        //
    }

    public function handle(FindByAccountInput $input): InvoiceOutput
    {
        if (!($invoiceDomain = $this->invoiceRepository->findById($input->id))) {
            throw new NotFoundException('Invoice not found');
        }

        if (!($account = $this->accountRepository->findByApiKey($input->apiKey))) {
            throw new NotFoundException('Account not found');
        }

        if ($invoiceDomain->accountId !== $account->id) {
            throw new NotFoundException('Invoice not found');
        }

        return new InvoiceOutput(
            id: $invoiceDomain->id,
            accountId: $invoiceDomain->accountId,
            amount: $invoiceDomain->amount,
            status: $invoiceDomain->status->label(),
            type: $invoiceDomain->type,
            cardLastDigits: $invoiceDomain->cardLastDigits,
            createdAt: $invoiceDomain->createdAt->format('Y-m-d H:i:s'),
        );
    }
}
