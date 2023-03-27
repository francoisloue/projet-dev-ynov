<?php
require_once("./class/dbSetting.php");
require_once("./class/newItem.php");
require_once("./class/category.php");
$DB = new DBHandler();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $encoded = file_get_contents("php://input");
    $decode = json_decode($encoded, true);
    $itemName = $decode["itemName"];
    if ($decode["itemDescription"] != ""){
        $itemDescription = $decode["itemDescription"];
    }
    if ($decode["itemImageURL"]) {
        $itemIllustration = $decode["itemImageURL"];
    }
    if (is_null($category = $DB->getFromDbByParam("category","name", $decode["itemCategory"]))) {
        $newCategory = new Category($decode["itemCategory"]);
        $itemCategory = $DB->getFromDbByParam("category","name", $decode["itemCategory"])["id"];
    } else {
        $itemCategory = $category["id"];
    }
    $itemPrice = $decode["itemPrice"];
    $newItem = new  Item($itemName, $itemDescription, $itemPrice, $itemCategory, $itemIllustration);
}