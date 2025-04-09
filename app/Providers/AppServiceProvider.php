<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Core\Repository as RepositoryInterface;
use App\Repository;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            RepositoryInterface\AccountRepositoryInterface::class,
            Repository\AccountRepository::class
        );

        $this->app->singleton(
            RepositoryInterface\InvoiceRepositoryInterface::class,
            Repository\InvoiceRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
