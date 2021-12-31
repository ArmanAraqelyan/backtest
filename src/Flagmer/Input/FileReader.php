<?php 

namespace Flagmer\Input;

class FileReader implements InputInterface
{
    private $stream;

    public function __construct($path)
    {
        $this->stream = fopen($path, 'r');
    }
    
    public function get($max = null): ?string
    {
        $max = $max ?? 0xFFFF;

        $data = fread($this->stream, $max);
        return $data ? $data : null;
    }

    public function __destruct()
    {
        fclose($this->stream);
    }
}
