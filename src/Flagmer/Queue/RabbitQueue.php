<?php

namespace Flagmer\Queue;

use Flagmer\RabbitMQ\Rabbit;

class RabbitQueue implements QueueInterface
{
    private $Rabbit;
    private $key;

    public function __construct($key)
    {
        $this->Rabbit = new Rabbit();
        $this->key = $key;
    }
    
    public function add($elem)
    {
        $this->Rabbit->add($elem, $this->key);
    }

    public function get()
    {
        $msg = $this->Rabbit->get($this->key);

        if ($msg === null) {
            return null;
        }

        return $msg->body;
    }
}