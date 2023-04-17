<?php

namespace controllers;

session_start(['cookie_lifetime' => 60,]); // Время сессии 10 минут

use inc\Education;
use inc\Experience;
use inc\PlaceOfWork;
use inc\Town;
use inc\TypeOfWork;
use inc\Vacancy;
use repo\Repository;
use SuperjobAPI;
use SuperjobAPIException;

header("Content-type: application/json; charset=utf-8");

$file = __FILE__;
$file = strtr($file, '\\', '/'); # Замена слешей
include_once(dirname($file) . '/../inc/SuperjobAPI.php');
include_once(dirname($file) . '/../inc/apikey.php');

require_once(__DIR__ . '/../autoload.php');

header('Content-type: application/json; charset=utf-8');

class VacancyController
{
    private SuperjobAPI $API;
    private Repository $repository;

    public function __construct()
    {
        try {
            $this->API = new SuperjobAPI();
            $this->API->setSecretKey(CLIENT_SECRET);
        } catch (SuperjobAPIException $e) {
            $error = $e->getMessage();
            die(json_encode($error));
        }

        $this->repository = new Repository();
    }

    public function getAllVacancyByPage(int $page): array
    {
//        $vacancies = $API->vacancies(array('keyword' => 'php', 'town' => 4, 'page' => 1, 'count' => 5));
        $vacancies = $this->API->vacancies(array('count' => 10, 'page' => $page));
        $_SESSION['is_more'] = $vacancies['more'];
        if ($_SESSION['is_more']) {
            return $this->toVacancy($vacancies['objects']);
        } else {
            return ["we not have more vacancies. Team AREA"];
        }
    }

    public function saveVacanciesInDatabase() {
        $this->repository->addVacancies($this->getAllVacancyByPage(1));
    }

    public function getTotal():int {
        return $this->API->vacancies(array('count' => 1, 'page' => 1))['total'];
    }

    private function toVacancy(array $arr): array
    {
        $result = [];
        foreach ($arr as $vacancy) {

            $result[] = new Vacancy(
                $vacancy['id'],
                $vacancy['payment_from'],
                $vacancy['payment_to'],
                $vacancy['profession'],
                $vacancy['work'],
                $vacancy['candidat'],
                new TypeOfWork($vacancy['type_of_work']['id'], $vacancy['type_of_work']['title']),
                new PlaceOfWork($vacancy['place_of_work']['id'], $vacancy['place_of_work']['title']),
                new Education($vacancy['education']['id'], $vacancy['education']['title']),
                new Experience($vacancy['experience']['id'], $vacancy['experience']['title']),
                $vacancy['catalogues'],
                new Town($vacancy['town']['id'], $vacancy['town']['title'], $vacancy['town']['declension'], $vacancy['town']['genitive']),
                $vacancy['client_logo'],
                $vacancy['age_from'],
                $vacancy['age_to'],
                $vacancy['firm_name'],
                $vacancy['firm_activity'],
                $vacancy['phone'],
            );
        }

        return $result;
    }
}