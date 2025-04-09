<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Core\UseCase\Account\CreateAccountUseCase;
use App\Core\UseCase\Account\Data\AccountCreateInput;
use App\Core\UseCase\Account\Data\FindByApiKeyInput;
use App\Core\UseCase\Account\FindByApiKeyUseCase;
use App\Http\Requests\AccountRequest;

class AccountController
{
    public function index(FindByApiKeyUseCase $useCase): array
    {
        return (array) $useCase->handle(new FindByApiKeyInput(auth()->user()->api_key));
    }

    public function store(AccountRequest $accountRequest, CreateAccountUseCase $useCase): array
    {
        return (array) $useCase->handle(new AccountCreateInput(
            $accountRequest->name,
            $accountRequest->email,
        ));
    }
}
