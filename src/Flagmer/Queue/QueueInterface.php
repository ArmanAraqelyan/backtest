<?php

namespace Flagmer\Queue;

interface QueueInterface
{
    public function add($elem);
    public function get();
}