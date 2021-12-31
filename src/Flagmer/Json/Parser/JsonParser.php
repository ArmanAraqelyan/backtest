<?php

namespace Flagmer\Json\Parser;

class JsonParser
{
    public function decode(string $plane)
    {
        return json_decode($plane);
    }

    public function encode($elem)
    {
        return json_encode($elem);
    }
}