<?php

namespace Susheelbhai\Laratrack;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Susheelbhai\Laratrack\Services\Facades\Laratrack;
use Susheelbhai\Laratrack\Services\LaratrackService;

class LaratrackServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laratrack');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->app->bind('laratrack', function(){
            return new LaratrackService();
        });
        $loader = AliasLoader::getInstance();
        $loader->alias('Laratrack', \Susheelbhai\Laratrack\Services\Facades\Laratrack::class);
    }

    
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Susheelbhai\Laratrack\Commands\UpdateENV::class,
            ]);
        }
        $checkLicence = Laratrack::trackLicence();
        if ($checkLicence==false) {
            Laratrack::notifyLicence();
        }
        
    }

}
