<?php

include_once('../inc/functions.php');

require_once('../inc/Response.php');
require_once ('../repo/Repository.php');

use inc\Response;
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
        die(json_encode(new Response(false, "Требуется POST запрос")));
    }
}