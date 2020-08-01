<?php

Co\run(function() {
    go(function() {
        $client = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);
        if (!$client->connect('127.0.0.1', 9502, 0.5))
        {
            exit("connect failed. Error: {$client->errCode}\n");
        }
        $client->send(json_encode(["action" => "create", "params" => ["content" => "test content"]]));
        echo $client->recv();
        $client->close();
    });
});
