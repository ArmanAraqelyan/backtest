<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rat.rmq2.cloudamqp.com', 5672, 'dkjhqzkf', 'rqLmfT6rayp-A4MWKNcuC6NwUgCabDHq','dkjhqzkf');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
};

$channel->basic_consume('hello', '', false, true, false, false, $callback);
$channel->wait();
$channel->close();
$connection->close();
?>