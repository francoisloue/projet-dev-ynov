<?php 
$f = fopen("test.txt","w");
try{
    include_once "header.php";
    include_once "class/dbSetting.php";
    $encoded = file_get_contents("php://input");
    $decode = json_decode($encoded, true);
    $mail = $decode["mail"];
    $password = $decode["password"];
    $db = new DBHandler();
    $data = $db->getInDB("password,userType,id","user","mail",$mail)[0];
    if(password_verify($password,$data["password"])){
        echo($data["id"]);
    }else{
        echo("false");
    }
}catch(ERROR $e){
    fwrite($f,$e);
    echo("error");
}catch(Exception $e){
    fwrite($f,$e);
    echo("error");
}

?>