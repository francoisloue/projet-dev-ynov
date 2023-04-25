<?php
try {
    header('Content-type: text/javascript');
    require_once("class/dbSetting.php");
    require_once("class/newItem.php");
    require_once("class/category.php");
    require_once("./header.php");

    $DB = new DBHandler();
    
    $request_error = "You've got a wrong id or research";
    $request_URI = $_SESSION["request"];
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case ("POST"):
            $encoded = file_get_contents("php://input");
            $decode = json_decode($encoded, true);
            $itemName = $decode["itemName"];
            $itemDescription = null;
            if ($decode["itemDescription"] != "") {
                $itemDescription = $decode["itemDescription"];
            }
            if ($decode["itemImageURL"]!= "") {
                $itemIllustration = $decode["itemImageURL"];
            } else {
                $itemIllustration = "https://cdn0.iconfinder.com/data/icons/cosmo-layout/40/box-512.png";
            }
            $itemCategory=$decode["itemCategory"];
            $itemPrice = $decode["itemPrice"];
            $newItem = new Item($itemName, $itemDescription, $itemPrice, $itemCategory, $itemIllustration);
            echo(json_encode("Item created successfully"));
        case ("GET"):
            if (count($request_URI)>2) {
                if (intval($request_URI[2]) != 0) {
                    echo(json_encode($DB->getFromDbByParam("items","id", intval($request_URI[2]))));
                } else {
                    switch ($request_URI[2]) {
                        case("category"):
                            if (intval($request_URI[3]) != 0) {
                                echo(json_encode($DB->getInDB("*", "items", "categoryID", $request_URI[3])));
                            } else {
                                echo json_encode($request_error);
                            }
                            break;
                        case("randomCategory"):
                            if (intval($request_URI[3]) != 0) {
                                echo(json_encode($DB->getAllRandomn(5, $request_URI[3])));
                            } else {
                                echo json_encode($request_error);
                            }
                            break;
                    }
                    
                }
            } else {
                echo(json_encode($DB->getInDB("*","items")));
            }
            break;
    }
} catch(ERROR $e){
    echo false;
} catch(Exception $e){
    echo false;
}
