<?php 
try{
    include_once "class/dbSetting.php";
    include_once "header.php";
    $encoded = file_get_contents("php://input");
    $decode = json_decode($encoded, true);
    $idUser = $decode["idUser"];
    $db = new DBHandler();
    echo(json_encode($db->getInDB("*","user","id",$idUser)[0]));
}catch(ERROR $e){
    echo(false);
}catch(Exception $e){
    echo(false);
}
?>