<?php

declare(strict_types = 1);

namespace App\Core\UseCase\Account;

use App\Core\Exception\NotFoundException;
use App\Core\Repository\AccountRepositoryInterface;
use App\Core\UseCase\Account\Data\AccountOutput;
use App\Core\UseCase\Account\Data\FindByApiKeyInput;

class FindByApiKeyUseCase
{
    public function __construct(protected AccountRepositoryInterface $accountRepository)
    {
        //
    }

    public function handle(FindByApiKeyInput $input): AccountOutput
    {
        if (!($account = $this->accountRepository->findByApiKey($input->apiKey))) {
            throw new NotFoundException('Account not found');
        }

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
