<?php

use \Slim\App;
use App\Models\Todo;
use App\Drivers\Data\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem as Flysystem;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response) {
        
        // getting todos
        // $todo = new Todo($this->dataDriver);
        // $todolist = $todo->get();
        // --

        $response = $this->view->render($response, 'index.phtml', [
            // 'todolist' => $todolist,
        ]);

        return $response;
    });

    $app->get('/todos', function (Request $request, Response $response) {
        throw Exception('Not implemented!');
    });

    $app->post('/todos', function (Request $request, Response $response) {
        throw Exception('Not implemented!');
    });

    $app->put('/todos', function (Request $request, Response $response) {
        throw Exception('Not implemented!');
    });

    $app->delete('/todos', function (Request $request, Response $response) {
        throw Exception('Not implemented!');
    });

};