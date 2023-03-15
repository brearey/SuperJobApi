<?php

require_once ('api/inc/Message.php');
use inc\Message;

header('Content-type: application/json');

$db = db_connect('test');

function db_connect($db_name) {
    if (!file_exists($db_name . ".db")) {
        $db = new PDO("sqlite:" . $db_name . ".db");
        createMessageTable($db);
        createWorkerTable($db);
        return $db;
    }
    $db = new PDO("sqlite:" . $db_name . ".db");
    return $db;
}

function createMessageTable(PDO $db) {
    $sql='CREATE TABLE message (
            sender_name TEXT NOT NULL,
            message_text TEXT NOT NULL,
            sender_token TEXT NOT NULL,
            receiver_token TEXT NOT NULL
        )';

    $db->exec($sql);
}

function addMessage(PDO $db, Message $message) {
    $sql = "INSERT INTO message (sender_name, message_text, sender_token, receiver_token) VALUES (:sender_name, :message_text, :sender_token, :receiver_token)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sender_name', $message->sender_name);
    $stmt->bindValue(':message_text', $message->message_text);
    $stmt->bindValue(':sender_token', $message->sender_token);
    $stmt->bindValue(':receiver_token', $message->receiver_token);
    $stmt->execute();
}

function getMessagesByReceiver(PDO $db, $receiver_token): array {
    $sql = "SELECT * FROM message WHERE receiver_token = '".$receiver_token."'";
    $statement = $db->prepare($sql);
    $statement->execute();

    $messages = [];
    while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
        $messages[] = new Message($row['sender_name'],$row['message_text'],$row['sender_token'],$row['receiver_token']);
    }
    return $messages;
}

function createWorkerTable(PDO $db) {
    $sql='CREATE TABLE worker (
            token TEXT NOT NULL,
            name TEXT NOT NULL,
            age INTEGER NOT NULL,
            town TEXT NOT NULL
        )';

    $db->exec($sql);
}