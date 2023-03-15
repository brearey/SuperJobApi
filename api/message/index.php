<?php

include_once('../inc/functions.php');

require_once('../inc/Response.php');
require_once ('../inc/Message.php');
require_once('../repo/RepositoryMessage.php');

use inc\Response;
use inc\Message;
use repo\RepositoryMessage;

header("Content-type: application/json; charset=utf-8");

$repo = new RepositoryMessage('messages');

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $result = $repo->get_messages_to_reciever($_GET['receiver_token']);
        echo(json_encode($result));
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);
        $message = new Message($data['sender_name'], $data['message_text'], $data['sender_token'], $data['receiver_token']);
        $result = $repo->add_message($message);
        echo(json_encode($result));
    }
}
