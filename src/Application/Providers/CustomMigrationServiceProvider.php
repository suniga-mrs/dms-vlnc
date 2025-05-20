<?php

namespace App\Application\Providers;

use Illuminate\Support\ServiceProvider;

class CustomMigrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->extend('migrator', function ($migrator, $app) {
            $migrator->path(database_path('domain_migrations'));
            return $migrator;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
