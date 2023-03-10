<?php

namespace inc;

class Message
{
public $sender_name;
public $message_text;

    /**
     * @param $sender_name
     * @param $message_text
     */
    public function __construct($sender_name, $message_text)
    {
        $this->sender_name = $sender_name;
        $this->message_text = $message_text;
    }


}