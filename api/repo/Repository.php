<?php

namespace repo;

require_once (__DIR__ . '/../autoload.php');

use ArrayObject;
use inc\Employer;
use inc\Message;
use inc\Response;
use inc\Worker;
use PDO;

define('DB_NAME', 'superjob');

class Repository
{
    private static PDO $database;

    public function __construct()
    {
        $this->db_connect();
    }

    private function db_connect(): void
    {
        $path = __DIR__ . '/../';
        $db_file = $path . DB_NAME . ".db";
        if (!file_exists($db_file)) {
            self::$database = new PDO("sqlite:" . $db_file);
            $this->createMessageTable();
            $this->createWorkerTable();
            $this->createEmployerTable();
            $this->createVacancyTable();
        }
        self::$database = new PDO("sqlite:" . $db_file);
    }

    public function addMessage(Message $message): Response
    {
        $sql = "INSERT INTO message (sender_name, message_text, sender_token, receiver_token) VALUES (:sender_name, :message_text, :sender_token, :receiver_token)";
        $stmt = self::$database->prepare($sql);
        $stmt->bindValue(':sender_name', $message->sender_name);
        $stmt->bindValue(':message_text', $message->message_text);
        $stmt->bindValue(':sender_token', $message->sender_token);
        $stmt->bindValue(':receiver_token', $message->receiver_token);

        if ($stmt->execute()) {
            http_response_code(200);
            return new Response(true, null, "Message has been saved");
        } else {
            http_response_code(400);
            return new Response(false, null, "Error saving message");
        }
    }

    public function getMessagesByReceiver($receiver_token): array
    {
        $sql = "SELECT * FROM message WHERE receiver_token = '".$receiver_token."'";
        $statement = self::$database->prepare($sql);
        $statement->execute();

        $messages = [];
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $messages[] = new Message($row['sender_name'],$row['message_text'],$row['sender_token'],$row['receiver_token']);
        }
        return $messages;
    }

    //CRUD for workers
    public function addWorker(Worker $worker): Response {
        // check by token exist
        $response = $this->getWorkerByToken($worker->token);
        if ($response->status) {
            return new Response(false, null, "Token already exists");
        }

        $sql = "INSERT INTO worker (token, name, age, town) VALUES (:token, :name, :age, :town)";
        $stmt = self::$database->prepare($sql);
        $stmt->bindParam(':token', $worker->token);
        $stmt->bindParam(':name', $worker->name);
        $stmt->bindParam(':age', $worker->age);
        $stmt->bindParam(':town', $worker->town);
        if (!$stmt->execute()) {
            return new Response(false, null, "Error creating worker");
        }
        return new Response(true, null, "Worker has been created");
    }

    public function getWorkerByToken(String $token): Response {
        $sql = "SELECT * FROM worker WHERE token = '".$token."'";

        $statement = self::$database->prepare($sql);
        $statement->execute();

        $workers = [];
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $workers[] = new Worker($row['token'],$row['name'],$row['age'],$row['town']);
        }

        if ($workers) {
            $worker = $workers[0];
            return new Response(true, $worker, "Success");
        } else {
            return new Response(false,null, "Worker is not exist");
        }
    }

    public function addEmployer(Employer $employer): Response {
        // check by token exist
        $response = $this->getEmployerByToken($employer->token);
        if ($response->status) {
            return new Response(false, null, "Token already exists");
        }

        $sql = "INSERT INTO employer (token, company_name, town, full_name, photo_uri) VALUES (:token, :company_name, :town, :full_name, :photo_uri)";
        $stmt = self::$database->prepare($sql);
        $stmt->bindParam(':token', $employer->token);
        $stmt->bindParam(':company_name', $employer->company_name);
        $stmt->bindParam(':town', $employer->town);
        $stmt->bindParam(':full_name', $employer->full_name);
        $stmt->bindParam(':photo_uri', $employer->photo_uri);
        if (!$stmt->execute()) {
            return new Response(false, null, "Error creating employer");
        }
        return new Response(true, null, "Employer has been created");
    }

    public function getEmployerByToken(String $token): Response {
        $sql = "SELECT * FROM employer WHERE token = '".$token."'";

        $statement = self::$database->prepare($sql);
        $statement->execute();

        $employers = [];
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $employers[] = new Employer($row['token'],$row['company_name'],$row['town'],$row['full_name'], $row['photo_uri']);
        }

        if ($employers) {
            $worker = $employers[0];
            return new Response(true, $worker, "Success");
        } else {
            return new Response(false,null, "Employer is not exist");
        }
    }

    public function addVacancies(Array $vacancies):void {
        foreach ($vacancies as $vacancy) {
            $sql = "INSERT INTO vacancy (
                id,
                payment_from,
                payment_to,
                profession,
                work,
                candidat,
                type_of_work__id,
                type_of_work__title,
                place_of_work__id,
                place_of_work__title,
                education__id,
                education__title,
                experience__id,
                experience_title,
                catalogues,
                town__id,
                town__title,
                town__declension,
                town__genitive,
                client_logo,
                age_from,
                age_to,
                firm_name,
                firm_activity,
                phone
                )
                VALUES (
                :id,
                :payment_from,
                :payment_to,
                :profession,
                :work,
                :candidat,
                :type_of_work__id,
                :type_of_work__title,
                :place_of_work__id,
                :place_of_work__title,
                :education__id,
                :education__title,
                :experience__id,
                :experience_title,
                :catalogues,
                :town__id,
                :town__title,
                :town__declension,
                :town__genitive,
                :client_logo,
                :age_from,
                :age_to,
                :firm_name,
                :firm_activity,
                :phone
                )";
                $catalogues = json_encode($vacancy->catalogues);
                $stmt = self::$database->prepare($sql);
                $stmt->bindParam(':id', $vacancy->id);
                $stmt->bindParam(':payment_from', $vacancy->payment_from);
                $stmt->bindParam(':payment_to', $vacancy->payment_to);
                $stmt->bindParam(':profession', $vacancy->profession);
                $stmt->bindParam(':work', $vacancy->work);
                $stmt->bindParam(':candidat', $vacancy->candidat);
                $stmt->bindParam(':type_of_work__id', $vacancy->type_of_work->id);
                $stmt->bindParam(':type_of_work__title', $vacancy->type_of_work->title);
                $stmt->bindParam(':place_of_work__id', $vacancy->place_of_work->id);
                $stmt->bindParam(':place_of_work__title', $vacancy->place_of_work->title);
                $stmt->bindParam(':education__id', $vacancy->education->id);
                $stmt->bindParam(':education__title', $vacancy->education->title);
                $stmt->bindParam(':experience__id', $vacancy->experience->id);
                $stmt->bindParam(':experience_title', $vacancy->experience->title);
                $stmt->bindParam(':catalogues', $catalogues);
                $stmt->bindParam(':town__id', $vacancy->town->id);
                $stmt->bindParam(':town__title', $vacancy->town->title);
                $stmt->bindParam(':town__declension', $vacancy->town->declension);
                $stmt->bindParam(':town__genitive', $vacancy->town->genitive);
                $stmt->bindParam(':client_logo', $vacancy->client_logo);
                $stmt->bindParam(':age_from', $vacancy->age_from);
                $stmt->bindParam(':age_to', $vacancy->age_to);
                $stmt->bindParam(':firm_name', $vacancy->firm_name);
                $stmt->bindParam(':firm_activity', $vacancy->firm_activity);
                $stmt->bindParam(':phone', $vacancy->phone);
                $stmt->execute();
        }
    }

    public function clearTable(string $tableName) {
        $sql = 'DELETE FROM '. $tableName.' ';
        $stmt = self::$database->prepare($sql);
        $stmt->execute();
    }

    private function createVacancyTable():void {
        $sql = 'CREATE TABLE vacancy (
            id INTEGER NOT NULL,
            payment_from INTEGER NOT NULL,
            payment_to INTEGER NOT NULL,
            profession TEXT NOT NULL,
            work TEXT,
            candidat TEXT NOT NULL,

            type_of_work__id INTEGER,
            type_of_work__title TEXT,

            place_of_work__id INTEGER,
            place_of_work__title TEXT,

            education__id INTEGER,
            education__title TEXT,

            experience__id INTEGER NOT NULL,
            experience_title TEXT NOT NULL,

            catalogues TEXT,

            town__id INTEGER,
            town__title TEXT,
            town__declension TEXT,
            town__genitive TEXT,

            client_logo TEXT,
            age_from INTEGER NOT NULL,
            age_to INTEGER NOT NULL,
            firm_name TEXT,
            firm_activity TEXT,
            phone TEXT
        )';
        self::$database->exec($sql);
    }

    private function createMessageTable(): void
    {
        $sql='CREATE TABLE message (
            sender_name TEXT NOT NULL,
            message_text TEXT NOT NULL,
            sender_token TEXT NOT NULL,
            receiver_token TEXT NOT NULL
        )';

        self::$database->exec($sql);
    }

    private function createWorkerTable(): void
    {
        $sql='CREATE TABLE worker (
            token TEXT NOT NULL,
            name TEXT NOT NULL,
            age INTEGER NOT NULL,
            town TEXT NOT NULL
        )';

        self::$database->exec($sql);
    }

    private function createEmployerTable(): void
    {
        $sql='CREATE TABLE employer (
            token TEXT NOT NULL,
            company_name TEXT NOT NULL,
            town TEXT NOT NULL,
            full_name TEXT NOT NULL,
            photo_uri TEXT NOT NULL
        )';

        self::$database->exec($sql);
    }
}