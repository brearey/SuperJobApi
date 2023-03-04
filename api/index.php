<?php
header("Content-type: application/json; charset=utf-8");
//header('Access-Control-Allow-Origin: *');

$employer = array(
    'employee_name' => 'Employee name Artur',
    'workey_city' => 'Yakutsk',
    'photo_link' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Flag_of_Sakha.svg/240px-Flag_of_Sakha.svg.png',
    'uid' => 'Уникальный ID пользователя Артур'
);

switch($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if (checkAppKey()) {
            switch ($_SERVER['REQUEST_URI']) {
                case '/superjob/api/':
                    echo json_encode($employer);
                    break;
                case '/superjob/api/array':
                    echo "array epte";
                    break;
            }
        }
        break;
    case "POST":
        if (checkAppKey()) {
            $postData = file_get_contents('php://input');
            $data = json_decode($postData, true);

            if (checkUserID($data['uid'])) {
                $user = array(
                    'username' => 'Артем Петров',
                    'image' => 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
                );
                echo json_encode($user);
            }
        } else {
            http_response_code(400);
        }
        break;
}

function checkAppKey() {
    $result = $_SERVER["HTTP_APPKEY"] == 1234;
    if (!$result) {http_response_code(401);}
    return $result;
}

function checkUserID($userid) {
    if ($userid == "12345") {
        http_response_code(200);
        return true;
    }
    else {
        http_response_code(404);
    }
}