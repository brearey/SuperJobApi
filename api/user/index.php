<?php

include_once ('../include/functions.php');

require_once('../include/Response.php');
require_once ('../repo/Repository.php');

use include\Response;
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

        //echo json_encode($repo->get_users());
    } else {
        http_response_code(400);
        die(json_encode(new Response(false, "Требуется GET запрос")));
    }
}
