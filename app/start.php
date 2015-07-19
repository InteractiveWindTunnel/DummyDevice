<?php
require (__DIR__.'/../vendor/autoload.php');

$device = new WindTunnel\DummyDevice\Device();
$client = new WindTunnel\DummyDevice\TunnelClient('realm1');

$client->setDevice($device);

$client->addTransportProvider(new \Thruway\Transport\PawlTransportProvider('ws://ita-crossbar.herokuapp.com/ws'));

$client->start();
