<?php

include_once ('../include/functions.php');

require_once ('../Message.php');
require_once ('../repo/Repository.php');

use api\Message;
use repo\Repository;

header("Content-type: application/json; charset=utf-8");
//header("Content-type: text/html; charset=utf-8");

$repo = new Repository();

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);
        $token = $data['token'];
        $name = $data['name'];
        $age = $data['age'];
        echo json_encode($repo->add_user($token, $name, $age));
    } else {
        http_response_code(400);
        die(json_encode(new Message(false, "Требуется POST запрос")));
    }
}