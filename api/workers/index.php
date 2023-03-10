<?php

include_once('../inc/functions.php');

require_once('../inc/Response.php');
require_once ('../repo/RepositoryWorker.php');

use inc\Response;
use repo\RepositoryWorker;

header("Content-type: application/json; charset=utf-8");

$repo = new RepositoryWorker('workers');

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode($repo->get_workers());
    } else {
        http_response_code(400);
        die(json_encode(new Response(false, "GET required")));
    }
}