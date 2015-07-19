<?php
require (__DIR__.'/../vendor/autoload.php');

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);

$http = new React\Http\Server($socket);
$http->on('request', function ($request, $response) {
    $response->writeHead(200, array('Content-Type' => 'text/plain'));
    $response->end("Hello World!\n");
});

$port = isset($_ENV["PORT"]) ? $_ENV["PORT"] : 9090;
$socket->listen($port);

$device = new WindTunnel\DummyDevice\Device();
$client = new WindTunnel\DummyDevice\TunnelClient('realm1', $loop);

$client->setDevice($device);

$client->addTransportProvider(new \Thruway\Transport\PawlTransportProvider('ws://ita-crossbar.herokuapp.com/ws'));

$client->start();
