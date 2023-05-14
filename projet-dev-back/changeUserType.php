<?php 
$f = fopen("test.txt","w");
try{
    include_once "header.php";
    include_once "class/dbSetting.php";
    $encoded = file_get_contents("php://input");
    $decode = json_decode($encoded, true);
    $userId = $decode["userId"];
    $userType = $decode["userType"];
    $db = new DBHandler();
    $db->updateInDB("user","userType",$userType,"id",$userId);
    echo(true);
}catch(ERROR $e){
    fwrite($f,$e);
    echo("error");
}catch(Exception $e){
    fwrite($f,$e);
    echo("error");
}
?>