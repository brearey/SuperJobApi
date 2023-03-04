<?php
header("Content-type: application/json; charset=utf-8");
//header("Content-type: text/html; charset=utf-8");

if (checkAppKey()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        if ($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif') {
            $uploaddir = getcwd().DIRECTORY_SEPARATOR . 'files/';
            $uploadfile = $uploaddir . basename($_FILES['file']['name']);
            try {
                if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                    throw new Exception('Could not move file');
                }
                echo "Upload Complete!";
                } catch (Exception $e) {
                    die ('File did not upload: ' . $e->getMessage());
                }
            } else {
                http_response_code(400);
                $error_message = 'Only jpg, jpeg, gif and png files are allowed.';
                echo $error_message;
                exit();
            }
        }
} else {
    http_response_code(400);
}

function checkAppKey() {
    $result = $_SERVER["HTTP_APPKEY"] == 1234;
    if (!$result) {http_response_code(401);}
    return $result;
}