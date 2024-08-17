<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\FornecedorRepository;
use App\Repositories\FornecedorRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FornecedorRepositoryInterface::class, FornecedorRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
