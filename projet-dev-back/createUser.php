<?php 
try{
    include_once "class/user.php";
    include_once "header.php";
    $encoded = file_get_contents("php://input");
    $decode = json_decode($encoded, true);
    $username = $decode["username"];
    $mail = $decode["mail"];
    $password = $decode["password"];
    $address = $decode["address"];
    $user = new User($username,$password,$mail,new DateTime(),$address);
    $idUser = $user->addEmployee();
    echo($idUser);
}catch(ERROR $e){
    echo(false);
}catch(Exception $e){
    echo(false);
}


?>