<?php
try{
    include_once "class/dbSetting.php";
    include_once "header.php";
    $encoded = file_get_contents("php://input");
    $decode = json_decode($encoded, true);
    $idCategory = $decode["idCategory"];
    $quantity = $decode["quantity"];
    $db = new DBHandler();
    echo(json_encode($db->getAllRandomn($quantity,$idCategory)));
}catch(ERROR $e){
    echo(false);
}catch(Exception $e){
    echo(false);
}

?>