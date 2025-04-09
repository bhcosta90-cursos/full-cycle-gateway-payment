<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Core\UseCase\Invoice\CreateInvoiceUseCase;
use App\Core\UseCase\Invoice\Data\CreateInvoiceInput;
use App\Http\Requests\InvoiceRequest;

final class InvoiceController
{
    public function store(InvoiceRequest $invoiceRequest, CreateInvoiceUseCase $useCase): array
    {
        return (array) $useCase->handle(new CreateInvoiceInput(
            apiKey: auth()->user()->api_key,
            amount: $invoiceRequest->amount,
            description: $invoiceRequest->description,
            type: 'credit-card',
            cardNumber: $invoiceRequest->credit_card->number,
            cardCvv: $invoiceRequest->credit_card->cvv,
            cardHolderName: $invoiceRequest->credit_card->name,
            cardExpiredMonth: $invoiceRequest->credit_card->month,
            cardExpiredYear: $invoiceRequest->credit_card->year,
        ));
    }
}
