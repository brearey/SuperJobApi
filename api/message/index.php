<?php

include_once('../inc/functions.php');

require_once('../inc/Response.php');
require_once ('../inc/Message.php');
require_once('../repo/Repository.php');

use inc\Response;
use inc\Message;
use repo\Repository;

header("Content-type: application/json; charset=utf-8");

$repo = new Repository();

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        //Check empty
        if (isset($_GET['receiver_token']))
        {
            $result = $repo->getMessagesByReceiver($_GET['receiver_token']);
            echo(json_encode($result));
        } else
        {
            http_response_code(400);
            echo(json_encode(new Response(false, null, "All parameters required")));
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);
        //Check empty
        if (isset($data['sender_name']) and isset($data['message_text']) and isset($data['sender_token']) and isset($data['receiver_token']) )
        {
            $message = new Message($data['sender_name'], $data['message_text'], $data['sender_token'], $data['receiver_token']);
            echo json_encode($repo->addMessage($message));
        } else
        {
            http_response_code(400);
            echo(json_encode(new Response(false, null, "All parameters required")));
        }
    }
}
