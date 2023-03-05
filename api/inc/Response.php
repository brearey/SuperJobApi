<?php

namespace inc;
class Response
{
    public $status;
    public $text;
    public function __construct($status, $text)
    {
        $this->status = $status;
        $this->text = $text;
    }
}