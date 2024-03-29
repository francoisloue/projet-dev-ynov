<?php
header('Content-type: text/javascript');
require_once("./class/dbSetting.php");
require_once("./header.php");
$DB = new DBHandler();
/* This code is handling the routing of requests to different PHP files based on the first segment of
the URL path. */
$_SESSION["request"] = explode("/",$_SERVER["REQUEST_URI"]);
$request = $_SESSION["request"];
switch ($request[1]) {
    case "items":
        require __DIR__ . '/items.php';
        break;
    case "users":
        require __DIR__ . '/user.php';
        break;
    case "category":
        require __DIR__ . '/category.php';
        break;
    case "cart" :
        require __DIR__ . '/cart.php';
        break;
    default:
        break;
}
 