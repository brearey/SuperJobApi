<?php

namespace include;
class Response
{
    public string $status;
    public string $text;
    public function __construct($status, $text)
    {
        $this->status = $status;
        $this->text = $text;
    }
}