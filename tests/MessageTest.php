<?php

namespace tests;
include_once('api/inc/Message.php');

use inc\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    private $message;

    public function testConstructMessage()
    {
        $message = new Message($this->message->sender_name, $this->message->message_text, $this->message->sender_token, $this->message->receiver_token);
        self::assertSame($this->message->sender_name, $message->sender_name);
        self::assertSame($this->message->message_text, $message->message_text);
        self::assertSame($this->message->sender_token, $message->sender_token);
        self::assertSame($this->message->receiver_token, $message->receiver_token);
    }

    // Вспомогательные методы
    protected function setUp(): void
    {
        // Настройка тестов
        $this->message = new Message(
            "senderName",
            "messageText",
            "senderToken",
            "receiverToken"
        );
    }

    protected function tearDown(): void
    {
        // Обнулить объекты, чтобы освободить RAM
        $this->message = null;
    }
}