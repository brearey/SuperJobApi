<?php

namespace controllers;

require_once (__DIR__ . '/../autoload.php');

use inc\Message;
use inc\Response;
use repo\Repository;

header('Content-type: application/json; charset=utf-8');

class MessageController
{
    private static Repository $repository;
    public function __construct(Repository $repository)
    {
        self::$repository = $repository;
    }

    public static function addMessage(): void
    {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);
        //Check empty
        if (isset($data['sender_name']) and isset($data['message_text']) and isset($data['sender_token']) and isset($data['receiver_token']) )
        {
            $message = new Message($data['sender_name'], $data['message_text'], $data['sender_token'], $data['receiver_token']);
            echo json_encode(self::$repository->addMessage($message));
        } else
        {
            http_response_code(400);
            echo(json_encode(new Response(false, null, "All parameters required")));
        }
    }

    public static function getMessages($receiver_token): void {
        //Check empty
        if (isset($receiver_token))
        {
            $result = self::$repository->getMessagesByReceiver($receiver_token);
            echo(json_encode($result));
        } else
        {
            http_response_code(400);
            echo(json_encode(new Response(false, null, "All parameters required")));
        }
    }
}