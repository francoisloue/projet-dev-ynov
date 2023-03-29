<?php 
try{
    include_once "class/dbSetting.php";
    include_once "header.php";
    $db = new DBHandler();
    echo(json_encode($db->getInDB("*","userType")));
}catch(ERROR $e){
    echo(false);
}catch(Exception $e){
    echo(false);
}
?>