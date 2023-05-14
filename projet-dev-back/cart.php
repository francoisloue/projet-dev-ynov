<?php
$f = fopen("test.txt","w");
try {
    header('Content-type: text/javascript');
    require_once("class/dbSetting.php");
    require_once("./header.php");

    $DB = new DBHandler();
    
    $request_error = "You've got a wrong id or research";
    $request_URI = $_SESSION["request"];
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case ("POST"):
            $encoded = file_get_contents("php://input");
            $decode = json_decode($encoded, true);
            $idUser = $decode["idUser"];
            $idItem = $decode["idItem"];
            $quantity = $decode["quantity"];
            $data = array(
                "userID" => $idUser,
                "productID" => $idItem,
                "quantity" =>$quantity,
            );
            $idCartItem = $DB->insert($data,"itemscart");
            echo($idCartItem);
            break;

            
        case("PUT"):
            if (count($request_URI)>3) {
                if (intval($request_URI[3]) != 0) {
                    echo(json_encode($request_URI));
                    if($request_URI[2]=="addOne"){
                        echo("addOne");
                        $DB->updateInDB("itemscart","quantity","`quantity`+1","id",$request_URI[3]);
                        break;
                    }else if($request_URI[2]=="removeOne"){
                        if($DB->getInDB("quantity","itemscart","id",$request_URI[3])[0]["quantity"]==1){
                            $DB->delete("itemscart","id",$request_URI[3]);
                            break;
                        }else{
                            $DB->updateInDB("itemscart","quantity","`quantity`-1","id",$request_URI[3]);
                            break;
                        }
                    }else{
                        echo($request_error);
                    }
                } else {
                    echo($request_error);
                }
            } else {
                echo($request_error);
            }
            break;


        case ("GET"):
            if (count($request_URI)>2) {
                if (intval($request_URI[2]) != 0) {
                    echo(json_encode($DB->getCartItems($request_URI[2])));
                } else {
                    echo($request_error);
                }
            } else {
                echo($request_error);
            }
            break;
        case("DELETE"):
            if (count($request_URI)>2) {
                if (intval($request_URI[2]) != 0) {
                    $DB->delete("itemscart","id",$request_URI[2]);
                    echo(true);
                } else {
                    echo($request_error);
                }
            } else {
                echo($request_error);
            }
            break;
    }
} catch(ERROR $e){
    fwrite($f,$e);
    echo false;
} catch(Exception $e){
    fwrite($f,$e);
    echo false;
}
