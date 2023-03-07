<?php

namespace repo;

require_once ('../inc/Response.php');
require_once ('../inc/User.php');

use inc\User;
use SQLite3;
use inc\Response;

class Repository
{
    private static $database;

    public function __construct()
    {
        self::$database = $this->db_connect();
    }

    private function db_connect(): SQLite3 {
        $database_name = 'superjob';
        $path = '../';
        $db = new SQLite3($path.$database_name . '.db');
        if(!file_exists($path.$database_name . ".db")) {
            $sql='CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            token TEXT,
            name TEXT,
            age TEXT
        )';
            $db->query($sql);
        }
        return $db;
    }

    public function add_user($token, $name, $age): Response {
        $db = self::$database;
        // check by token exist
        $response = $this->get_user_by_token($token);
        if ($response->status) {
            return new Response(false, null, "Token already exists");
        }

        $sql = "INSERT INTO users (token, name, age) VALUES (:token, :name, :age)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);
        if ($stmt->execute()) {
            $stmt->close();
            return new Response(true, null, "User has been created");
        } else {
            $stmt->close();
            return new Response(false, null, "Error creating user " . $db->lastErrorMsg());
        }
    }

    public function get_users(): array {
        $db = self::$database;
        $sql = "SELECT * FROM users";
        $result = $db->query($sql);
        $array = array();
        while($data = $result->fetchArray(SQLITE3_ASSOC))
        {
            $array[] = $data;
        }
        return $array;
    }

    public function get_user_by_token($token): Response {
        $db = self::$database;
        $sql = "SELECT * FROM users WHERE token = '".$token."'";
        $result = $db->query($sql);
        $array = array();
        while($data = $result->fetchArray(SQLITE3_ASSOC))
        {
            $array[] = $data;
        }

        if ($array) {
            $user = new User($array[0]['id'], $array[0]['token'], $array[0]['name'], $array[0]['age']);
            return new Response(true, $user, "Success");
        } else {
            return new Response(false,null, "User is not exist. " . $db->lastErrorMsg());
        }
    }
}