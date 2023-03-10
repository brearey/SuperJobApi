<?php

namespace repo;

require_once ('../inc/Response.php');
require_once ('../inc/Message.php');

use inc\Message;
use SQLite3;
use inc\Response;

class RepositoryMessage
{
    private static $database;

    public function __construct($db_name)
    {
        self::$database = $this->db_connect($db_name);
    }

    private function db_connect($db_name) {
        $path = '../';
        if(!file_exists($path.$db_name . '.db')) {
            $db = new SQLite3($path.$db_name . '.db');
            $sql='CREATE TABLE message (
            message_text TEXT NOT NULL,
            sender_name TEXT NOT NULL
        )';
            $db->query($sql);
        }
        $db = new SQLite3($path.$db_name . '.db');
        return $db;
    }

    public function add_message(Message $message): Response {
        $db = self::$database;

        $sql = "INSERT INTO message (message_text, sender_name) VALUES (:message_text, :sender_name)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':message_text', $message->message_text);
        $stmt->bindParam(':sender_name', $message->sender_name);
        if ($stmt->execute()) {
            $stmt->close();
            return new Response(true, null, "Message has been saved");
        } else {
            $stmt->close();
            return new Response(false, null, "Error saving message " . $db->lastErrorMsg());
        }
    }

    public function get_messages(): array {
        $db = self::$database;
        $sql = "SELECT * FROM message";
        $result = $db->query($sql);
        $array = array();
        while($data = $result->fetchArray(SQLITE3_ASSOC))
        {
            $array[] = $data;
        }
        return $array;
    }

    public function get_messages_by_sender($sender_name) {
        $db = self::$database;
        $sql = "SELECT * FROM message WHERE sender_name = '".$sender_name."'";
        $result = $db->query($sql);
        $array = array();
        while($data = $result->fetchArray(SQLITE3_ASSOC))
        {
            $array[] = $data;
        }

        if ($array) {
            return $array;
        } else {
            return new Response(false,null, "User has no messages");
        }
    }
}