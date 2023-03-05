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
        $result = $repo->get_user_by_token($_SERVER['HTTP_TOKEN']);
        if (!$result->status) {
            die(json_encode(new Response(false, $result->text)));
        } else {
            echo (json_encode(new Response(true, $result->text)));
        }
    } else {
        http_response_code(400);
        die(json_encode(new Response(false, "Требуется GET запрос")));
    }
}
