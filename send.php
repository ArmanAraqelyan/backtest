<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rat.rmq2.cloudamqp.com', 5672, 'dkjhqzkf', 'rqLmfT6rayp-A4MWKNcuC6NwUgCabDHq','dkjhqzkf');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

for ($i = 0; $i < 10; $i++) {
$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');
echo " [x] Sent 'Hello World!'\n";
}


$channel->close();
$connection->close();
?>