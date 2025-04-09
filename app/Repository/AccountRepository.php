<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Core\Domain\AccountDomain;
use App\Core\Repository\AccountRepositoryInterface;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Throwable;

final class AccountRepository implements AccountRepositoryInterface
{
    public function __construct(protected Account $model)
    {
        //
    }

    public function create(AccountDomain $invoiceDomain): AccountDomain
    {
        $result = $this->model->create([
            'id'      => $invoiceDomain->id,
            'name'    => $invoiceDomain->name,
            'email'   => $invoiceDomain->email,
            'api_key' => $invoiceDomain->apiKey,
            'balance' => $invoiceDomain->balance,
        ]);

        return $this->converteDomain($result);
    }

    /**
     * @throws Throwable
     */
    public function updateBalance(AccountDomain $accountDomain, float $value): AccountDomain
    {
        try {
            DB::beginTransaction();

            $result = $this->model->select(['balance'])
                ->whereId($accountDomain->id)
                ->lockForUpdate()
                ->first();

            $result->update([
                'balance' => $accountDomain->balance + $value,
            ]);

            DB::commit();

            return $this->converteDomain($result->refresh());
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function findByApiKey(string $apiKey): ?AccountDomain
    {
        return $this->converteDomain($this->model->whereApiKey($apiKey)->first());
    }

    public function findById(string $id): ?AccountDomain
    {
        return $this->converteDomain($this->model->whereId($id)->first());
    }

    private function converteDomain(?object $data): ?AccountDomain
    {
        if ($data) {
            return new AccountDomain(
                name: $data->name,
                email: $data->email,
                apiKey: $data->api_key,
                balance: $data->balance,
                id: $data->id,
                createdAt: $data->created_at,
            );
        }

        return null;
    }
}
