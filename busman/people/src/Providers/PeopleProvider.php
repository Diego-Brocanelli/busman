<?php

namespace Busman\People\Providers;

use Illuminate\Support\ServiceProvider;

class PeopleProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->publishes([$this->configPath() => config_path('people.php')], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../../install-stubs/migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'people');
    }


    /**
     * Path to configuration file.
     *
     * @return string
     */
    public function configPath(): string
    {
        return realpath(__DIR__ . '/../../install-stubs/config/people.php');
    }
}
