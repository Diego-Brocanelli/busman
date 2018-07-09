<?php

namespace Busman\Acl\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Busman\Acl\Models\Permission;
use Illuminate\Support\Facades\Gate;

class AclProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->publishes([$this->configPath() => config_path('acl.php')], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../../install-stubs/migrations');

        if (class_exists('Laravel\Passport\Passport')) {
            Route::group(['prefix' => 'api'], function() {
                Passport::routes();
            });
        }

        $this->tryGates();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'acl');
    }


    /**
     * Path to configuration file.
     *
     * @return string
     */
    public function configPath(): string
    {
        return realpath(__DIR__ . '/../../install-stubs/config/acl.php');
    }

    /**
     * Permission check
     */
    public function tryGates(){
        try {
            $permissions = Permission::all();
        } catch (\Exception $e) {
            return [];
        }

        foreach ($permissions as $permission) {
            Gate::define($permission->name, function ($user) use ($permission){
                return $user->hasPermission($permission->name) || $user->ownsTeam($user->currentTeam) ;
            });
        }
    }
}
