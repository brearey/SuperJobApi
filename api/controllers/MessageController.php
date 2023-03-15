<?php

namespace controllers;

use inc\Message;
use inc\Response;
use repo\Repository;

require_once ('../inc/Message.php');
require_once ('../inc/Response.php');
require_once ('../repo/Repository.php');

class MessageController
{
    private static Repository $repository;
    public function __construct($repository)
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

    public static function getMessages(): void {
        //Check empty
        if (isset($_GET['receiver_token']))
        {
            $result = self::$repository->getMessagesByReceiver($_GET['receiver_token']);
            echo(json_encode($result));
        } else
        {
            http_response_code(400);
            echo(json_encode(new Response(false, null, "All parameters required")));
        }
    }
}