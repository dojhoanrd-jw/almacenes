<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\ArticuloFilterInterface;
use App\Http\Controllers\ArticuloFilter;
use App\Http\Controllers\NombreArticuloFilter;
use App\Http\Controllers\PrecioMinFilter;
use App\Http\Controllers\PrecioMaxFilter;
use App\Http\Controllers\StockMinFilter;
use App\Services\FacturaServiceInterface;
use App\Services\FacturaService;
use App\Repositories\PedidoRepositoryInterface;
use App\Repositories\PedidoRepository;
use App\Services\UsuarioStrategies\UsuarioStrategyInterface;
use App\Services\UsuarioStrategies\DefaultUsuarioStrategy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticuloFilterInterface::class, function ($app) {
            return new ArticuloFilter([
                new NombreArticuloFilter(),
                new PrecioMinFilter(),
                new PrecioMaxFilter(),
                new StockMinFilter(),
            ]);
        });

        $this->app->bind(FacturaServiceInterface::class, FacturaService::class);
        $this->app->bind(PedidoRepositoryInterface::class, PedidoRepository::class);
        $this->app->bind(UsuarioStrategyInterface::class, DefaultUsuarioStrategy::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
