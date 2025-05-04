<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Person\PersonRepositoryInterface;
use App\Infrastructure\Repositories\PersonRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
