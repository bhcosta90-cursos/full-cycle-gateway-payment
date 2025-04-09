<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Core\Domain\AccountDomain;
use App\Core\Repository\AccountRepositoryInterface;
use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountRepository implements AccountRepositoryInterface
{
    protected Model $model;

    public function __construct()
    {
        $this->model = new Account();
    }

    public function create(AccountDomain $accountDomain): AccountDomain
    {
        $result = $this->model->create([
            'id'      => $accountDomain->id,
            'name'    => $accountDomain->name,
            'email'   => $accountDomain->email,
            'api_key' => $accountDomain->apiKey,
            'balance' => $accountDomain->balance,
        ]);

        return $this->converteDomain($result);
    }

    /**
     * @throws \Throwable
     */
    public function updateBalance(AccountDomain $accountDomain): AccountDomain
    {
        try {
            DB::beginTransaction();

            $result = $this->model->select(['balance'])
                ->whereId($accountDomain->id)
                ->lockForUpdate()
                ->first();

            $result->update([
                'balance' => $accountDomain->balance,
            ]);

            DB::commit();

            return $this->converteDomain($result->refresh());
        } catch (\Throwable $exception) {
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

    protected function converteDomain(?object $data): ?AccountDomain
    {
        if ($data) {
            return new AccountDomain(
                name: $data->name,
                email: $data->email,
                apiKey: $data->api_key,
                balance: $data->balance,
                id: $data->id,
                createdAt: $data->created_at,
                updatedAt: $data->updated_at,
            );
        }

        return null;
    }
}
