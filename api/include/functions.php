<?php
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