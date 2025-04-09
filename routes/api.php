<?php

declare(strict_types = 1);

use App\Http\Controllers\AccountController;
use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(AccountController::class)->prefix('account')->group(function () {
    Route::post('/', 'store');

    Route::middleware(ApiKeyMiddleware::class)->group(function () {
        Route::get('/', 'index');
    });
});
