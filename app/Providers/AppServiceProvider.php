<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\FornecedorRepository;
use App\Repositories\FornecedorRepositoryInterface;

/**
 * @OA\Info(
 *     title="API de Fornecedores",
 *     version="1.0.0",
 *     description="Teste de PHP da Revenda Mais",
 *     @OA\Contact(
 *         email="allyson.dunke@gmail.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */

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
