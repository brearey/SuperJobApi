<?php

include_once('../inc/functions.php');

require_once('../inc/Response.php');
require_once ('../repo/Repository.php');

use inc\Response;
use repo\Repository;

header("Content-type: application/json; charset=utf-8");

$repo = new Repository();

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode($repo->get_users());
    } else {
        http_response_code(400);
        die(json_encode(new Response(false, "Требуется GET запрос")));
    }
}