<?php
namespace Flagmer\Handler;

use Flagmer\Queue\RabbitQueue;
use Flagmer\Category\CategoryFactory;
use Flagmer\Json\Parser\JsonParser;

class Worker {

    private $queue;

    public function __construct(string $queueName)
    {
        $this->queue = new RabbitQueue($queueName);
    }

    public function run()
    {
        while($raw = $this->queue->get()) {
            $parsedFile = (new JsonParser())->decode($raw);
            if (is_object($parsedFile))
            {
                $parsedFile = [$parsedFile];
            }

            foreach($parsedFile as $fileRow)
            {
                $category = CategoryFactory::createCategory($fileRow->category, $fileRow->data);

                $category->makeAction($fileRow->task);
            }
        }
    }

}