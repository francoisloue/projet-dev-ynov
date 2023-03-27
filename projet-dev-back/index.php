<?php
header('Content-type: text/javascript');
require_once("./class/dbSetting.php");
$DB = new DBHandler();
$request = $_SERVER["REQUEST_URI"];
switch ($request) {
    case "/post":
        require __DIR__ . '/request/post.php';
        break;
    case "/user":
        require __DIR__ . '/request/user.php';
        break;
    default:
        http_response_code(404);
        break;
}
