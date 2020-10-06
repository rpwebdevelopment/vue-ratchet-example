<?php
/**
 * Created by PhpStorm.
 * User: rporter
 * Date: 22/09/2020
 * Time: 14:37
 */
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use TestApp\TestApp;

require dirname(__DIR__) . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new TestApp()
        )
    ),
    8080
);

$server->run();
