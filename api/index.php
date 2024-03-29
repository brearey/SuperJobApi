<?php

require_once (__DIR__ . '/autoload.php');
require_once ('inc/functions.php');

use controllers\EmployerController;
use controllers\MessageController;
use controllers\VacancyController;
use controllers\WorkerController;
use repo\Repository;

checkAppKey();

$repository = new Repository();

$url = explode('/', $_GET['q']);
$endpoint = $url[0];

switch ($endpoint) {
    case ('message'): {
        $messageController = new MessageController($repository);
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $receiver_token = $url[1];
            $messageController::getMessages($receiver_token);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $messageController::addMessage();
        }
        break;
    }

    case ('worker'): {
        $workerController = new WorkerController($repository);
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            // in GET request token like this: superjob/api/worker/artur_token
            $token = $url[1];
            $workerController::getWorkerByToken($token);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $workerController::addWorker();
        }
        break;
    }

    case ('employer'): {
        $employerController = new EmployerController($repository);
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $token = $url[1];
            $employerController::getEmployerByToken($token);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $employerController::addEmployer();
        }
        break;
    }

    case ('vacancy'): {
        $vacancyController = new VacancyController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            if (!empty($url[1])) {
                $page = intval($url[1]);
            } else {
                $page = 1;
            }
            echo json_encode($vacancyController->getAllVacancyByPage($page));
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {

        }
        break;
    }

    default: {
        http_response_code(400);
    }
}