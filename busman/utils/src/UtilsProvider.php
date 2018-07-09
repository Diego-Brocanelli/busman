<?php

namespace Busman\Utils;

use Illuminate\Support\ServiceProvider;
use Busman\Utils\Console\CustomModelMakeCommand;
use Busman\Utils\Console\CommandsList;

class UtilsProvider extends ServiceProvider
{

    function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        parent::__construct($app);

        new PaginationMacro;
    }

    /**
     * Path to configuration file.
     *
     * @return string
     */
    public function configPath(): string
    {
        return realpath(__DIR__ . '/config/utils.php');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utils');

        $this->publishes([$this->configPath() => config_path('utils.php')], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'busman');

        $this->app->extend('command.model.make', function (){
            return new CustomModelMakeCommand($this->app->files);
        });
    }
}
