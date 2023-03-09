<?php

include_once('../inc/functions.php');

require_once('../inc/Response.php');
require_once ('../repo/RepositoryWorker.php');

use inc\Response;
use repo\RepositoryWorker;

header("Content-type: application/json; charset=utf-8");

$repo = new \repo\RepositoryWorker('superjob');

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $result = $repo->get_worker_by_token($_SERVER['HTTP_TOKEN']);
        echo(json_encode($result));
    } else {
        http_response_code(400);
        die(json_encode(new Response(false, null, "GET required")));
    }
}
