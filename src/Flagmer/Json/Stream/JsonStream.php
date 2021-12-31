<?php

namespace Flagmer\Json\Stream;

use Exception;
use Flagmer\Input\InputInterface;
use JsonException;

class JsonStream
{
    private $stream;
    private $cache = "";

    public function __construct(InputInterface $input)
    {
        $this->stream = $input;
    }

    public function get(int $num = 1): ?string
    {
        $text = "[";
        
        for ($i = 0; $i < $num; $i++) {
            try {
                $text .= $this->getOne() . ",";
            } catch (Exception $exc) {
                break;
            }
        }
        
        $text = rtrim($text, ',');

        $text .= "]";

        return $text !== "[]" ? $text : null;
    }
    
    public function getAll(): string
    {
        $filedata = '';
        while ($newfiledata = $this->stream->get())
        {
            $filedata .= $newfiledata;
        }
        return $filedata;
    }

    public function getOne(): string
    {
        $text = &$this->cache;

        do {
            $apostropheCount = 0;
            $nestedIndex = 0;
            
            $textLen = strlen($text);
            
            $start = strpos($text, "{");
            $i = $start;
            do {
                if ($text[$i] == "\"") {
                    $apostropheCount ++; 
                } elseif ($text[$i] == "{" && $apostropheCount % 2 === 0) {
                    $nestedIndex++;
                } elseif ($text[$i] == "}" && $apostropheCount % 2 === 0) {
                    $nestedIndex--;
                }
            } while($nestedIndex > 0 && $i++);
        } while ((($i == 0 || $i == $textLen) && $text .= $this->stream->get()) && strlen($text) !== $textLen);
        if ($i == 0 || $i == $textLen) {
            throw new JsonException("Can not parse the object:" . PHP_EOL . $text);
        }

        $json = substr($text, $start, $i - $start + 1);
        $text = substr($text, $i + 1);

        return $json;
    }
}