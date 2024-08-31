<?php

namespace ApiCrud\ApiCrudPackage\Operations;

class GenerateControllerOperation
{
    public function handle()
    {
        $controllerTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Controller')
        );

        File::put(app_path("/Http/Controllers/Api/{$name}Controller.php"), $controllerTemplate);
    }
}