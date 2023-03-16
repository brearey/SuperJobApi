<?php

namespace repo;

require_once (__DIR__ . '/../autoload.php');

use inc\Message;
use inc\Response;
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
}