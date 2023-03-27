<?php
header('Content-type: text/javascript');
require_once("./class/dbSetting.php");
$DB = new DBHandler();
$request = explode("/",$_SERVER["REQUEST_URI"]);
switch ($request[1]) {
    case "items":
        require __DIR__ . '/items.php';
        break;
    case "users":
        require __DIR__ . '/user.php';
        break;
    default:
        break;
}
 