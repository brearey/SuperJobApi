<?php

namespace signup\repo;

use api\Message;
use SQLite3;

class Repository
{
    private static $database;

    public function __construct()
    {
        self::$database = $this->db_connect();
    }

    private function db_connect() {
        $database_name = 'superjob';
        $path = dirname($_SERVER['DOCUMENT_ROOT']) . '/superjob/api/';
        if(!file_exists($path.$database_name . ".db")) {
            $db = new SQLite3($path.$database_name . '.db');
            $sql='CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            token TEXT,
            name TEXT
        )';
            $db->query($sql);
        }else{
            $db = new SQLite3($path.$database_name . '.db');
        }
        return $db;
    }

    public function add_user($token, $name) {
        $db = self::$database;
        // check by token exist
        $message = $this->get_user_by_token($token);
        if ($message->status) {
            return new \api\Message(false, "Пользователь с таким токеном уже существует");
        }

        $sql = "INSERT INTO users (token, name) VALUES (:token, :name)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':name', $name);
        if ($stmt->execute()) {
            $stmt->close();
            return new \api\Message(true, "User has been created");
        } else {
            $stmt->close();
            return new \api\Message(false, "Error creating user " . $db->lastErrorMsg());
        }
    }

    public function get_users() {
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

    public function get_user_by_token($token) {
        $db = self::$database;
        $sql = "SELECT * FROM users WHERE token = '".$token."'";
        $result = $db->query($sql);
        $array = array();
        while($data = $result->fetchArray(SQLITE3_ASSOC))
        {
            $array[] = $data;
        }

        if ($array) {
            return new \api\Message(true, $array[0]);
        } else {
            return new \api\Message(false, "Пользователь не найден. " . $db->lastErrorMsg());
        }
    }
}