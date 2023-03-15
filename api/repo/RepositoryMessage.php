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
        $db = new SQLite3($path.$db_name . '.db');
        $tbl_message = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='message'");
        if(!$tbl_message) {
            $sql='CREATE TABLE message (
            sender_name TEXT NOT NULL,
            message_text TEXT NOT NULL,
            sender_token TEXT NOT NULL,
            reciever_token TEXT NOT NULL
        )';
            $db->query($sql);
        }
        return $db;
    }

    public function add_message(Message $message): Response {
        $db = self::$database;

        $sql = "INSERT INTO message (sender_name, message_text, sender_token, receiver_token) VALUES (:sender_name, :message_text, :sender_token, :receiver_token)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':sender_name', $message->sender_name);
        $stmt->bindParam(':message_text', $message->message_text);
        $stmt->bindParam(':sender_token', $message->sender_token);
        $stmt->bindParam(':receiver_token', $message->receiver_token);
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

    public function get_messages_to_reciever($receiver_token) {
        $db = self::$database;
        $sql = "SELECT * FROM message WHERE receiver_token = '".$receiver_token."'";
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