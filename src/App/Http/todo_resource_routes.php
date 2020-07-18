<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Http\Controllers\ExampleTodoController;
use App\Http\Middlewares\IndexExampleTodoMiddleware;
use App\Http\Middlewares\GetExampleTodoMiddleware;
use App\Http\Middlewares\CreateExampleTodoMiddleware;
use App\Http\Middlewares\UpdateExampleTodoMiddleware;
use App\Http\Middlewares\DeleteExampleTodoMiddleware;

return function (App $app) {
    $app->group('/api', function (App $app) {
        $app->get('/todos', ExampleTodoController::class . ':index')
            ->add(IndexExampleTodoMiddleware::class);

        $app->get('/todos/{id}', ExampleTodoController::class . ':show')
            ->add(GetExampleTodoMiddleware::class);

        $app->post('/todos', ExampleTodoController::class . ':create')
            ->add(CreateExampleTodoMiddleware::class);

        $app->put('/todos/{id}', ExampleTodoController::class . ':update')
            ->add(UpdateExampleTodoMiddleware::class);

        $app->delete('/todos/{id}', ExampleTodoController::class . ':delete')
            ->add(DeleteExampleTodoMiddleware::class);
    });
};