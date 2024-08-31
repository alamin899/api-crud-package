<?php

namespace ApiCrud\ApiCrudPackage\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ApiCrudCommand extends Command
{
    protected $signature = 'generate:crud {name}';
    protected $description = 'Generate API CRUD';

    public function handle(): void
    {
        $name = $this->argument('name');

        if (config('generator.controller')) {
            $this->generateController($name);
        }

        if (config('generator.model')) {
            $this->generateModel($name);
        }

        if (config('generator.request')) {
            $this->generateRequest($name);
        }

        if (config('generator.migration')) {
            $this->generateMigration($name);
        }

        $this->updateRoutes($name);

        $this->info('CRUD operations generated successfully!');
    }

    protected function generateController($name): void
    {
        $name = Str::ucfirst($name);
        $controllerTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Controller')
        );

        File::put(app_path("/Http/Controllers/Api/{$name}Controller.php"), $controllerTemplate);
    }

    protected function generateModel($name): void
    {
        $name = Str::ucfirst($name);

        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );

        File::put(app_path("/Models/{$name}.php"), $modelTemplate);
    }

    protected function generateRequest($name): void
    {
        $name = Str::ucfirst($name);
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        File::put(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
    }

    protected function generateMigration($name): void
    {
        $name = Str::lower($name);
        $tableName = strtolower(Str::plural($name));
        $migrationTemplate = str_replace(
            ['{{tableName}}'],
            [$tableName],
            $this->getStub('Migration')
        );

        $fileName = date('Y_m_d_His') . "_create_{$tableName}_table.php";
        File::put(database_path("/migrations/{$fileName}"), $migrationTemplate);
    }

    protected function updateRoutes($name): void
    {
        $name = Str::ucfirst($name);
        $routeTemplate = str_replace(
            ['{{modelNamePluralLowerCase}}', '{{modelName}}'],
            [strtolower(Str::plural($name)), $name],
            $this->getStub('Routes')
        );

        File::append(base_path('routes/api.php'), $routeTemplate);
    }


    protected function getStub($type)
    {
        return File::get(__DIR__."/../stubs/$type.stub");
    }
}