<?php

namespace controllers;

use inc\Vacancy;
use SuperjobAPI;

header("Content-type: application/json; charset=utf-8");

include_once(dirname(__FILE__) . '/../inc/SuperjobAPI.php');
include_once(dirname(__FILE__) . '/../inc/apikey.php');

require_once(__DIR__ . '/../autoload.php');

header('Content-type: application/json; charset=utf-8');

class VacancyController
{
    public function __construct()
    {
        try {
            $API = new SuperjobAPI(); //можно и так: SuperjobAPI::instance();
            $API->setSecretKey(CLIENT_SECRET);
//            $vacancies = $API->vacancies(array('keyword' => 'php', 'town' => 4, 'page' => 1, 'count' => 5));
            $vacancies = $API->vacancies(array('count' => 3));

//            $canEditOfFirstVacancy = $vacancies['objects'][0]['canEdit'];
            $only_vacancies = $this->toVacancy($vacancies['objects']);

            echo(json_encode($only_vacancies));
        } catch (SuperjobAPIException $e)
        {
            $error = $e->getMessage();
            die(json_encode($error));
        }
    }

    private function toVacancy(array $arr):array {
        $result = [];
        foreach ($arr as $vacancy) {
            $result[] = new Vacancy(
                $vacancy['payment_from'],
                $vacancy['payment_to'],
                $vacancy['profession'],
                $vacancy['work'],
                $vacancy['candidat'],
                $vacancy['type_of_work'],
                $vacancy['place_of_work'],
                $vacancy['education'],
                $vacancy['experience'],
                $vacancy['catalogues'],
                $vacancy['town'],
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