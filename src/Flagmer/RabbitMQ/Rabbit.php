<?php

namespace Flagmer\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Rabbit
{
    private const CONFIG = [
        'host' => 'rat.rmq2.cloudamqp.com',
        'port' => 5672,
        'user' => 'dkjhqzkf',
        'pass' => 'rqLmfT6rayp-A4MWKNcuC6NwUgCabDHq',
        'vhost' => 'dkjhqzkf'
    ];
    
    private $connection;
    private $channel;

    public function __construct(array $configs = [])
    {
        $configs = array_merge(self::CONFIG, $configs);     //giving priority to caller, so he can override static CONFIGs
        $connection = new AMQPStreamConnection(
            $configs['host'],
            $configs['port'],
            $configs['user'],
            $configs['pass'],
            $configs['vhost']
        );
        $this->connection = $connection;
        $this->channel = $this->connection->channel();
    }
    
    public function add($elem, $key)
    {        
        $this->channel->queue_declare($key, false, true, false, false);
        $msg = new AMQPMessage($elem);
        $this->channel->basic_publish($msg, '', $key);
    }

    public function get($key): ?AMQPMessage
    {
        $this->channel->queue_declare($key, false, true, false, false);
        $result = null;
        $this->channel->basic_consume($key, '', false, true, false, false, function($msg) use (&$result) {
            $result = $msg;
        });
        $this->channel->wait();
        return $result;
    }
  
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}