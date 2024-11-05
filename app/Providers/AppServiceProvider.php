<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Supplier\SupplierRepositoryInterface::class,
            \App\Repositories\Supplier\SupplierEloquentRepository::class
        );

        $this->app->bind(
            \App\Repositories\Address\AddressRepositoryInterface::class,
            \App\Repositories\Address\AddressEloquentRepository::class
        );

        $this->app->bind(
            \App\Repositories\Telephone\TelephoneRepositoryInterface::class,
            \App\Repositories\Telephone\TelephoneEloquentRepository::class
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
