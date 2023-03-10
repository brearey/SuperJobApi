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
        $result = $repo->get_messages_by_sender($_GET['sender_name']);
        echo(json_encode($result));
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $result = $repo->add_message(new Message($_POST['sender_name'], $_POST['message_text']));
        echo(json_encode($result));
    }
}
