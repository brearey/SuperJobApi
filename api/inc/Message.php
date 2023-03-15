<?php

namespace inc;

class Message
{
public $sender_name;
public $message_text;
public $sender_token;
public $receiver_token;

    /**
     * @param $sender_name
     * @param $message_text
     * @param $sender_token
     * @param $receiver_token
     */
    public function __construct($sender_name, $message_text, $sender_token, $receiver_token)
    {
        $this->sender_name = $sender_name;
        $this->message_text = $message_text;
        $this->sender_token = $sender_token;
        $this->receiver_token = $receiver_token;
    }


}