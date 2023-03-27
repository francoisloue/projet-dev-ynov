<?php
header('Content-type: text/javascript');
require_once("./class/dbSetting.php");
require_once("./header.php");
$DB = new DBHandler();
$request = explode("/",$_SERVER["REQUEST_URI"]);
switch ($request[1]) {
    case "items":
        require __DIR__ . '/projet-dev-ynov/projet-dev-back/items.php';
        break;
    case "users":
        require __DIR__ . '/projet-dev-ynov/projet-dev-back/user.php';
        break;
    default:
        break;
}
 