<?php

use inc\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    private $message;
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
    }
}