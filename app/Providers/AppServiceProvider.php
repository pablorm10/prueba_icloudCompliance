<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TokenService;
use App\Repositories\DocumentRepository;
use App\Services\DocumentService;
use App\Http\Responses\DocumentResponse;
use App\Services\DateService;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(DocumentRepository::class, function ($app) {
            return new DocumentRepository(); // Puedes agregar dependencias aquí si las tiene
        });

        // Registrar el servicio
        $this->app->bind(DocumentService::class, function ($app) {
            return new DocumentService(
                $app->make(DocumentRepository::class),
                $app->make(DocumentResponse::class),
                $app->make(DateService::class)
            );
        });

        $this->app->singleton(TokenService::class, function ($app) {
            return new TokenService();
        });

        $this->app->singleton(DateService::class, function ($app) {
            return new DateService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
