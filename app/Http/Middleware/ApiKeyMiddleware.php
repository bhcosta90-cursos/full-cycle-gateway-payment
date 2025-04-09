<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Core\UseCase\Account\Data\FindByApiKeyInput;
use App\Core\UseCase\Account\FindByApiKeyUseCase;
use App\Models\Account;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ApiKeyMiddleware
{
    public function __construct(protected FindByApiKeyUseCase $useCase)
    {

    }

    public function handle(Request $request, Closure $next)
    {
        abort_if(
            blank($apiKey = $request->header('x-api-key')),
            Response::HTTP_FORBIDDEN,
            'API key is invalid'
        );

        abort_if(
            blank($account = Account::where('api_key', $apiKey)->first()),
            Response::HTTP_FORBIDDEN,
            'API key is invalid'
        );

        Auth::login($account);

        return $next($request);
    }
}
