<?php

include_once ('../include/functions.php');

require_once ('../Message.php');
require_once ('../repo/Repository.php');

use api\Message;
use repo\Repository;

header("Content-type: application/json; charset=utf-8");

$repo = new Repository();

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode($repo->get_users());
    } else {
        http_response_code(400);
        die(json_encode(new Message(false, "Требуется GET запрос")));
    }
}