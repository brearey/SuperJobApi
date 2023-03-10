<?php

include_once('../inc/functions.php');

require_once('../inc/Response.php');
require_once ('../inc/Message.php');
require_once('../repo/RepositoryMessage.php');

use inc\Response;
use inc\Message;
use repo\RepositoryMessage;

header("Content-type: application/json; charset=utf-8");

$repo = new RepositoryMessage('superjob');

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $result = $repo->get_messages();
        echo(json_encode($result));
    }
}
