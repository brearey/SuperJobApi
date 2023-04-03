<?php

namespace controllers;

require_once(__DIR__ . '/../autoload.php');

use inc\Response;
use inc\Employer;
use repo\Repository;

header('Content-type: application/json; charset=utf-8');

class EmployerController
{
    private static Repository $repository;

    public function __construct(Repository $repository)
    {
        self::$repository = $repository;
    }

    public static function addEmployer(): void
    {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);

        //Check empty
        if (isset($data['token']) and isset($data['company_name']) and isset($data['town']) and isset($data['full_name'])) {
            $employer = new Employer($data['token'], $data['company_name'], $data['town'], $data['full_name'], $data['photo_uri']);
            echo json_encode(self::$repository->addEmployer($employer));
        } else {
            http_response_code(400);
            echo(json_encode(new Response(false, null, "All parameters required")));
        }
    }

    public static function getEmployerByToken($token): void
    {
        //Check empty
        if (isset($token)) {
            $result = self::$repository->getEmployerByToken($token);
            echo(json_encode($result));
        } else {
            http_response_code(400);
            echo(json_encode(new Response(false, null, "All parameters required")));
        }
    }
}