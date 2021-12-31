<?php

namespace Flagmer\Input;

Interface InputInterface
{
    public function get($max = null): ?string;
}
