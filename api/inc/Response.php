<?php

namespace inc;
class Response
{
    public $status;
    public $content;
    public $message;
    public function __construct($status, $content, $message)
    {
        $this->status = $status;
        $this->content = $content;
        $this->message = $message;
    }
}