<?php

use \Slim\App;
use App\Models\ModelExample;
use Swoole\Http\Request;
use Swoole\Server;
use App\Services\SocketHandlers\ExampleSocketHandler;

return function (App $app) {
    $server = new Server("0.0.0.0", 9502, SWOOLE_BASE, SWOOLE_SOCK_TCP);

    $server->set(array(
        'worker_num' => 2,
        'daemonize' => false,
        'backlog' => 128,
    ));

    $server->on('open', function(Server $server, Request $request) use ($app) {
        echo "connection open: {$request->fd}\n";
    });

    $server->on('receive', function(
        Server $server, 
        int $fd, 
        int $reactor_id, 
        string $frame
    ) use ($app) {
        echo "received message: {$frame}\n";

        $message = ($app->getContainer()->socketHandler)($frame);

        $server->send($fd, json_encode($message));
    });

    $server->on('close', function(Server $server, int $fd,  int $reactor_id) use ($app) {
        echo "connection close: {$fd}\n";
    });

    $server->start();
};