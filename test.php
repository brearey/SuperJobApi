<?php

require_once ('api/repo/Repository.php');
require_once ('api/inc/Message.php');
use repo\Repository;
use inc\Message;

header('Content-type: application/json');

$repository = new Repository('test');
$repository->addMessage(new Message('mama', 'message of mama', 'mama_token', 'son_token'));