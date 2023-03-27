<?php
$f = fopen("test.txt","w");
try{
    header('Content-type: text/javascript');
    require_once("class/dbSetting.php");
    require_once("class/newItem.php");
    require_once("class/category.php");
    require_once("./header.php");

    $DB = new DBHandler();
    
    $request_URI = explode("/", $_SERVER["REQUEST_URI"]);
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case ("POST"):
            $encoded = file_get_contents("php://input");
            $decode = json_decode($encoded, true);
            $itemName = $decode["itemName"];
            if ($decode["itemDescription"] != "") {
                $itemDescription = $decode["itemDescription"];
            }
            if ($decode["itemImageURL"]) {
                $itemIllustration = $decode["itemImageURL"];
            }
            if (is_null($category = $DB->getFromDbByParam("category", "name", $decode["itemCategory"]))) {
                $newCategory = new Category($decode["itemCategory"]);
                $itemCategory = $DB->getFromDbByParam("category", "name", $decode["itemCategory"])["id"];
            } else {
                $itemCategory = $category["id"];
            }
            $itemPrice = $decode["itemPrice"];
            $newItem = new  Item($itemName, $itemDescription, $itemPrice, $itemCategory, $itemIllustration);
        case ("GET"):
            echo(json_encode($DB->getInDB("*","items")));
    }
}catch(ERROR $e){
    fwrite($f,$e);
}catch(Exception $e){
    fwrite($f,$e);
}
