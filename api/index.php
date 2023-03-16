<?php

require_once (__DIR__ . '/autoload.php');

use controllers\MessageController;
use repo\Repository;

$repository = new Repository();

$url = explode('/', $_GET['q']);
$endpoint = $url[0];

switch ($endpoint) {
    case ('message'): {
        $messageController = new MessageController($repository);
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $receiver_token = $url[1];
            $messageController::getMessages($receiver_token);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $messageController::addMessage();
        }
    }
}