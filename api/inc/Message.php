<?php

namespace inc;

class Message
{
public String $sender_name;
public String $message_text;
public String $sender_token;
public String $receiver_token;

    /**
     * @param String $sender_name
     * @param String $message_text
     * @param String $sender_token
     * @param String $receiver_token
     */
    public function __construct(String $sender_name, String $message_text, String $sender_token, String $receiver_token)
    {
        $this->sender_name = $sender_name;
        $this->message_text = $message_text;
        $this->sender_token = $sender_token;
        $this->receiver_token = $receiver_token;
    }


}