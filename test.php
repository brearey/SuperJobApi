<?php

header('Content-type: application/json');

$db = db_connect('test');
selectMessageByReceiver($db, 'artur_token');

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

function insertMessage(PDO $db) {
    $sql = "INSERT INTO message (sender_name, message_text, sender_token, receiver_token) VALUES (:sender_name, :message_text, :sender_token, :receiver_token)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sender_name', 'jeka');
    $stmt->bindValue(':message_text', 'message at ' . time());
    $stmt->bindValue(':sender_token', 'jeka_token');
    $stmt->bindValue(':receiver_token', 'artur_token');
    $stmt->execute();
}

function selectMessageByReceiver(PDO $db, $receiver_token) {
    $sql = "SELECT * FROM message WHERE receiver_token = '".$receiver_token."'";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    echo ( json_encode($result) );
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