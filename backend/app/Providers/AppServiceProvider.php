<?php

namespace App\Providers;

use App\Repositories\EloquentRepository;
use App\Repositories\Repository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        $this->app->bind(Repository::class, function () {
            return new Repository(
                new EloquentRepository()
            );
        });
    }
}
