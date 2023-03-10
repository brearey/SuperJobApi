<?php

include_once('../inc/functions.php');

require_once ('../inc/Worker.php');
require_once('../inc/Response.php');
require_once ('../repo/RepositoryWorker.php');

use inc\Response;
use inc\Worker;
use repo\RepositoryWorker;

header("Content-type: application/json; charset=utf-8");
//header("Content-type: text/html; charset=utf-8");

$repo = new \repo\RepositoryWorker('workers');

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);
        $worker = new Worker($data['token'], $data['name'], $data['age'], $data['town']);
        echo json_encode($repo->add_worker($worker));
    } else {
        http_response_code(400);
        die(json_encode(new Response(false, null, "POST required")));
    }
}