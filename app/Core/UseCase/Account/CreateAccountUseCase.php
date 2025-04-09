<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Account;

use App\Core\Domain\AccountDomain;
use App\Core\Exception\NotFoundException;
use App\Core\Repository\AccountRepositoryInterface;
use App\Core\UseCase\Account\Data\AccountCreateInput;
use App\Core\UseCase\Account\Data\AccountOutput;

readonly class CreateAccountUseCase
{
    public function __construct(protected AccountRepositoryInterface $accountRepository)
    {
        //
    }

    public function handle(AccountCreateInput $input): AccountOutput
    {
        $account = new AccountDomain(
            name: $input->name,
            email: $input->email,
        );

        if ($this->accountRepository->findByApiKey($account->apiKey)) {
            throw new NotFoundException('API key already exists');
        }

        $this->accountRepository->create($account);

        return new AccountOutput(
            id: $account->id,
            apiKey: $account->apiKey,
            name: $account->name,
            email: $account->email,
            balance: $account->balance,
            createdAt: $account->createdAt->format('Y-m-d H:i:s'),
            updatedAt: $account->updatedAt->format('Y-m-d H:i:s'),
        );
    }
}
