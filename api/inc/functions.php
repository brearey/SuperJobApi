<?php

require_once('../inc/Response.php');

use inc\Response;

function checkAppKey(): bool
{
    $result = $_SERVER["HTTP_APPKEY"] == 1234;
    if (!$result) {http_response_code(401);}
    return $result;
}

function upload_file($name): void
{
    $extension = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
    if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
        $uploaddir = getcwd() . DIRECTORY_SEPARATOR . '../uploaded_files/';
        $uploadfile = $uploaddir . time() . '_' .basename($_FILES[$name]['name']);
        try {
            if (!move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)) {
                echo(json_encode(new Response(false, 'Could not move file')));
                throw new Exception('Could not move file');
            }
            echo(json_encode(new Response(true, 'Upload Complete')));
        } catch (Exception $e) {
            die (json_encode(new Response(false, 'File did not uploaded_files: ' . $e->getMessage())));
        }
    } else {
        http_response_code(400);
        $error_message = 'Only jpg, jpeg, gif and png files are allowed.';
        echo(json_encode(new Response(false, $error_message)));
        exit();
    }
}