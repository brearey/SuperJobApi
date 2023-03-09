<?php

namespace repo;

require_once ('../inc/Response.php');
require_once ('../inc/Worker.php');

use inc\Worker;
use SQLite3;
use inc\Response;

class RepositoryWorker
{
    private static $database;

    public function __construct($db_name)
    {
        self::$database = $this->db_connect($db_name);
    }

    private function db_connect($db_name): SQLite3 {
        $path = '../';
        $db = new SQLite3($path.$db_name . '.db');
        if(!file_exists($path.$db_name . ".db")) {
            $sql='CREATE TABLE worker (
            token TEXT NOT NULL,
            name TEXT NOT NULL,
            age INTEGET NOT NULL,
            town TEXT NOT NULL
        )';
            $db->query($sql);
        }
        return $db;
    }

    public function add_worker(Worker $worker): Response {
        $db = self::$database;
        // check by token exist
        $response = $this->get_worker_by_token($worker->token);
        if ($response->status) {
            return new Response(false, null, "Token already exists");
        }

        $sql = "INSERT INTO worker (token, name, age, town) VALUES (:token, :name, :age. :town)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token', $worker->token);
        $stmt->bindParam(':name', $worker->name);
        $stmt->bindParam(':age', $worker->age);
        $stmt->bindParam(':town', $worker->town);
        if ($stmt->execute()) {
            $stmt->close();
            return new Response(true, null, "User has been created");
        } else {
            $stmt->close();
            return new Response(false, null, "Error creating user " . $db->lastErrorMsg());
        }
    }

    public function get_workers(): array {
        $db = self::$database;
        $sql = "SELECT * FROM worker";
        $result = $db->query($sql);
        $array = array();
        while($data = $result->fetchArray(SQLITE3_ASSOC))
        {
            $array[] = $data;
        }
        return $array;
    }

    public function get_worker_by_token($token): Response {
        $db = self::$database;
        $sql = "SELECT * FROM worker WHERE token = '".$token."'";
        $result = $db->query($sql);
        $array = array();
        while($data = $result->fetchArray(SQLITE3_ASSOC))
        {
            $array[] = $data;
        }

        if ($array) {
            $worker = new Worker($array[0]['token'], $array[0]['name'], $array[0]['age'], $array[0]['town']);
            return new Response(true, $worker, "Success");
        } else {
            return new Response(false,null, "User is not exist. " . $db->lastErrorMsg());
        }
    }
}