<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Core\Repository as RepositoryInterface;
use App\Repository as RepositoryEloquent;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            RepositoryInterface\AccountRepositoryInterface::class,
            RepositoryEloquent\AccountRepository::class
        );

        $this->app->singleton(
            RepositoryInterface\InvoiceRepositoryInterface::class,
            RepositoryEloquent\InvoiceRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
