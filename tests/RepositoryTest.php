<?php

namespace tests;

include_once(__DIR__ . '\..\api\inc\Message.php');
include_once(__DIR__ . '\..\api\inc\Response.php');
include_once(__DIR__ . '\..\api\repo\Repository.php');

use inc\Message;
use inc\Response;
use PHPUnit\Framework\TestCase;
use repo\Repository;

class RepositoryTest extends TestCase
{
    private Repository $repository;
    private Message $message;

    public function testAddMessage(): void
    {
        $response = $this->repository->addMessage($this->message);
        self::assertTrue($response->status);
        self::assertSame(null, $response->content);
        self::assertEquals('Message has been saved', $response->message);
    }
    protected function setUp(): void
    {
        $this->repository = new Repository();
        $this->message = new Message('testSenderName', 'testMessageText', 'testSenderToken', 'testReceiverToken');
    }

    protected function tearDown(): void
    {
        $this->repository = null;
    }
}