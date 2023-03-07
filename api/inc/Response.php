<?php

namespace inc;
class Response
{
    public $status;
    public $user;
    public $message;
    public function __construct($status, $user, $message)
    {
        $this->status = $status;
        $this->user = $user;
        $this->message = $message;
    }
}