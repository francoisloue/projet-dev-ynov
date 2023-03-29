<?php
$f = fopen("test.txt","w");
header('Content-type: text/javascript');
require_once("./class/dbSetting.php");
require_once("./header.php");
$DB = new DBHandler();
fwrite($f,$_SERVER["REQUEST_URI"]);
$request = explode("/",$_SERVER["REQUEST_URI"]);
switch ($request[1]) {
    case "items":
        require __DIR__ . '/projet-dev-ynov/projet-dev-back/items.php';
        break;
    case "users":
        switch($request[2]):
            case "login":
                require __DIR__ .'/projet-dev-ynov/projet-dev-back/login.php';
                break;
            case "register":
                require __DIR__ .'/projet-dev-ynov/projet-dev-back/createUser.php';
                break;
            case "changeType":
                require __DIR__ .'/projet-dev-ynov/projet-dev-back/changeUserType.php';
                break;
            endswitch;
    default:
        break;
}
 