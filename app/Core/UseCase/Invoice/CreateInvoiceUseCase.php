<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Invoice;

use App\Core\Domain\InvoiceDomain;
use App\Core\Enum\Invoice\InvoiceStatusEnum;
use App\Core\Exception\NotFoundException;
use App\Core\Repository\AccountRepositoryInterface;
use App\Core\Repository\InvoiceRepositoryInterface;
use App\Core\UseCase\Invoice\Data\CreateInvoiceInput;
use App\Core\UseCase\Invoice\Data\InvoiceOutput;
use App\Core\ValueObject\CreditCardValueObject;

final readonly class CreateInvoiceUseCase
{
    public function __construct(
        protected AccountRepositoryInterface $accountRepository,
        protected InvoiceRepositoryInterface $invoiceRepository,
    ) {
    }

    public function handle(CreateInvoiceInput $input): InvoiceOutput
    {
        if (!($account = $this->accountRepository->findByApiKey($input->apiKey))) {
            throw new NotFoundException('Account not found');
        }

        $invoiceDomain = InvoiceDomain::create(
            accountId: $account->id,
            description: $input->description,
            type: $input->type,
            cardValue: new CreditCardValueObject(
                number: $input->cardNumber,
                cvv: $input->cardCvv,
                holderName: $input->cardHolderName,
                expiredYear: $input->cardExpiredYear,
                expiredMonth: $input->cardExpiredMonth,
            ),
            amount: $input->amount,
        );

        if (InvoiceStatusEnum::Approved === $invoiceDomain->status) {
            $this->accountRepository->updateBalance($account, $input->amount);
        }

        $this->invoiceRepository->create($invoiceDomain);

        return new InvoiceOutput(
            id: $invoiceDomain->id,
            accountId: $invoiceDomain->accountId,
            amount: $invoiceDomain->amount,
            status: $invoiceDomain->status->label(),
            type: $invoiceDomain->type,
            cardLastDigits: $invoiceDomain->cardLastDigits,
            createdAt: $invoiceDomain->createdAt->format('Y-m-d H:i:s'),
            updatedAt: $invoiceDomain->updatedAt->format('Y-m-d H:i:s'),
        );
    }
}
