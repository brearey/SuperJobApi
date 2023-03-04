<?php

namespace api;
class Message
{
    public $status;
    public $text;
    public function __construct($status, $text)
    {
        $this->status = $status;
        $this->text = $text;
    }
}