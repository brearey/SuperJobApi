<?php

namespace repo;

use SQLite3;
use include\Response;

class Repository
{
    private static SQLite3 $database;

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
        $message = $this->get_user_by_token($token);
        if ($message->status) {
            return new Response(false, "Пользователь с таким токеном уже существует");
        }

        $sql = "INSERT INTO users (token, name, age) VALUES (:token, :name, :age)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);
        if ($stmt->execute()) {
            $stmt->close();
            return new Response(true, "User has been created");
        } else {
            $stmt->close();
            return new Response(false, "Error creating user " . $db->lastErrorMsg());
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
            return new Response(true, $array[0]);
        } else {
            return new Response(false, "Пользователь не найден. " . $db->lastErrorMsg());
        }
    }
}