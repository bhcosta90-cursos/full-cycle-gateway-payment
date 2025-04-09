<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Core\Domain\InvoiceDomain;
use App\Core\Repository\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(protected Invoice $model)
    {
        //
    }

    public function create(InvoiceDomain $invoiceDomain): InvoiceDomain
    {
        $result = $this->model->create([
            'id'               => $invoiceDomain->id,
            'account_id'       => $invoiceDomain->accountId,
            'status'           => $invoiceDomain->status,
            'description'      => $invoiceDomain->description,
            'type'             => $invoiceDomain->type,
            'card_last_digits' => $invoiceDomain->cardLastDigits,
            'amount'           => $invoiceDomain->amount,
        ]);

        return $this->converteDomain($result);
    }

    /**
     * @throws Throwable
     */
    public function updateStatus(InvoiceDomain $invoiceDomain): InvoiceDomain
    {
        try {
            DB::beginTransaction();

            $response = $this->model->select(['balance'])
                ->whereId($invoiceDomain->id)->update([
                    'status' => $invoiceDomain->status,
                ]);

            dump($response);

            DB::commit();

            return $this->converteDomain($result->refresh());
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function findByAccountId(string $accountId): array
    {
        return Invoice::query()
            ->byAccountId($accountId)
            ->get()
            ->map(fn (Invoice $invoice) => $this->converteDomain($invoice))
            ->toArray();
    }

    public function findById(string $id): ?InvoiceDomain
    {
        return $this->converteDomain($this->model->whereId($id)->first());
    }

    private function converteDomain(?object $data): ?InvoiceDomain
    {
        if ($data) {
            return new InvoiceDomain(
                accountId: $data->account_id,
                status: $data->status,
                description: $data->description,
                type: $data->type,
                cardLastDigits: $data->card_last_digits,
                amount: $data->amount,
                id: $data->id,
                createdAt: $data->created_at,
            );
        }

        return null;
    }
}
