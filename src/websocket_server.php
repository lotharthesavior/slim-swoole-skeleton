<?php

use \Slim\App;
use App\Models\ModelExample;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
use App\Services\SocketHandlers\ExampleSocketHandler;

return function (App $app) {
    $server = new Server("0.0.0.0", 9501);

    $server->on("start", function (Server $server) use ($app) {
        echo "Swoole WebSocket Server is started at http://127.0.0.1:9501\n";
    });

    $server->on('open', function (Server $server, Swoole\Http\Request $request) use ($app) {
        echo "connection open: {$request->fd}\n";
    });

    $server->on('message', function (Server $server, Frame $frame) use ($app) {
        echo "received message: {$frame->data}\n";

        $message = ($app->getContainer()->socketHandler)($frame->data);

        foreach ($server->connections as $fd) {
            $server->push($fd, json_encode($message));
        }
    });

    $server->on('close', function (Server $server, int $fd) use ($app) {
        echo "connection close: {$fd}\n";
    });

    $server->start();
};
