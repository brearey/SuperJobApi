<?php

db_connect('test');
function db_connect($db_name) {
    $path = '';

    $db = new SQLite3($path.$db_name . '.db');
    if (!$db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='{message}';")) {
        $db = new SQLite3($path.$db_name . '.db');
        $sql="CREATE TABLE message (
            message_text TEXT NOT NULL,
            sender_name TEXT NOT NULL
        )";
        $db->query($sql);
    }
    return $db;
}