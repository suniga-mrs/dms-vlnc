<?php

namespace App\Application\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;
use App\Domain\References\LifeStageRepositoryInterface;
use App\Infrastructure\Repositories\PersonRepository;
use App\Infrastructure\Repositories\LifeStageRepository;
use App\Infrastructure\Repositories\SmallGroupRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
        $this->app->bind(LifeStageRepositoryInterface::class, LifeStageRepository::class);
        $this->app->bind(SmallGroupRepositoryInterface::class, SmallGroupRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            base_path('src/ConnectApp.Infrastructure/Persistence/Migrations'),
        ]);
    }
}
