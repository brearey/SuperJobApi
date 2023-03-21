<?php

namespace controllers;

require_once (__DIR__ . '/../autoload.php');

use inc\Message;
use inc\Response;
use inc\Worker;
use repo\Repository;

header('Content-type: application/json; charset=utf-8');

class WorkerController
{
    private static Repository $repository;
    public function __construct(Repository $repository)
    {
        self::$repository = $repository;
    }

    public static function addWorker():void {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);

        //Check empty
        if (isset($data['token']) and isset($data['name']) and isset($data['age']) and isset($data['token']) )
        {
            $worker = new Worker($data['token'], $data['name'], $data['age'], $data['town']);
            echo json_encode(self::$repository->addWorker($worker));
        } else
        {
            http_response_code(400);
            echo(json_encode(new Response(false, null, "All parameters required")));
        }
    }

    public static function getWorkerByToken($token): void {
        //Check empty
        if (isset($token))
        {
            $result = self::$repository->getWorkerByToken($token);
            echo(json_encode($result));
        } else
        {
            http_response_code(400);
            echo(json_encode(new Response(false, null, "All parameters required")));
        }
    }
}