<?php
namespace Api\ApiCrudPackage;

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
    }
}