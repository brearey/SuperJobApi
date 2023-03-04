<?php
require_once ('../Message.php');
require_once ('repo/Repository.php');
use api\Message;
use signup\repo\Repository;

header("Content-type: application/json; charset=utf-8");
//header("Content-type: text/html; charset=utf-8");

$repo = new Repository();

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['token'];
        $name = $_POST['name'];
        echo json_encode($repo->add_user($token, $name));
    } else {
        http_response_code(400);
        die(json_encode(new Message(false, "Требуется POST запрос")));
    }
}

function checkAppKey() {
    $result = $_SERVER["HTTP_APPKEY"] == 1234;
    if (!$result) {
        http_response_code(401);
        die(json_encode(new Message(false, "Неверный ключ приложения")));
    }
    return $result;
}