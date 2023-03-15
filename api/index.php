<?php

include_once ('repo/Repository.php');
include_once ('controllers/MessageController.php');
use controllers\MessageController;
use repo\Repository;

$repository = new Repository();

$endpoint = $_GET['q'];

switch ($endpoint) {
    case ('message'): {
        $messageController = new MessageController($repository);
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $messageController::getMessages();
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $messageController::addMessage();
        }
    }
}