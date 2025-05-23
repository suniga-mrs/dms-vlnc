<?php

namespace App\Application\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;
use App\Domain\References\LifeStageRepositoryInterface;
use App\Infrastructure\Repositories\PersonRepository;
use App\Infrastructure\Repositories\LifeStageRepository;
use App\Infrastructure\Repositories\SmallGroupRepository;
use App\Domain\Shared\DomainEventRepositoryInterface;
use App\Domain\Shared\UnitOfWorkInterface;
use App\Infrastructure\Repositories\DomainEventRepository;
use App\Infrastructure\Shared\DatabaseUnitOfWork;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // DB operations
        $this->app->bind(UnitOfWorkInterface::class, DatabaseUnitOfWork::class);

        // Repositories
        $this->app->bind(DomainEventRepositoryInterface::class, DomainEventRepository::class);
        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
        $this->app->bind(LifeStageRepositoryInterface::class, LifeStageRepository::class);
        $this->app->bind(SmallGroupRepositoryInterface::class, SmallGroupRepository::class);

        $this->loadMigrationsFrom(database_path('domain_migrations'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            base_path('src/Infrastructure/Persistence/Migrations'),
        ]);
    }
}
