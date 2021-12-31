<?php
namespace Flagmer\Handler;

use Flagmer\Queue\RabbitQueue;
use Flagmer\Input\FileReader;
use Flagmer\Json\Stream\JsonStream;

class QueueFiller {

    private $queue;
    private $stream;

    public function __construct(string $queueName, string $source)
    {
        $this->queue = new RabbitQueue($queueName);
        $this->stream = new JsonStream(new FileReader($source));
    }

    public function fill(int $chunkSize)
    {
        while ($data = $this->stream->get($chunkSize)) {
            $this->queue->add($data);
        }
    }
}