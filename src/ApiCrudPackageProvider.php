<?php
namespace ApiCrud\ApiCrudPackage;

use ApiCrud\ApiCrudPackage\Commands\ApiCrudCommand;
use Illuminate\Support\ServiceProvider;

class ApiCrudPackageProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/generator.php', 'generator'
        );
    }


    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/generator.php' => config_path('generator.php'),
        ]);

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->commands([
            ApiCrudCommand::class,
        ]);
    }
}