<?php

require 'vendor/autoload.php';

use \Slim\App;

$config = (require __DIR__ . '/src/settings.php')();
$app = new App(['settings' => $config]);
$container = $app->getContainer();

require __DIR__ . '/src/helpers.php';
(require __DIR__ . '/src/dependencies.php')($container);
(require __DIR__ . '/src/templates.php')($container);
(require __DIR__ . '/src/routes.php')($app);

if (in_array('--websocket', $argv)) {
    return (require __DIR__ . '/src/websocket_server.php')($app);
}

if (in_array('--tcpsocket', $argv)) {
    return (require __DIR__ . '/src/tcpsocket_server.php')($app);
}

(require __DIR__ . '/src/http_server.php')($app); // <-- swoole http server

// $app->run(); // <-- cgi http servers