<?php

namespace App\Providers;

use App\Interfaces\CnpjInterface;
use App\Repositories\CnpjRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CnpjInterface::class, CnpjRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
