<?php 
$f = fopen("test.txt","w");
try{
    include_once "class/user.php";
    include_once "header.php";
    $encoded = file_get_contents("php://input");
    $decode = json_decode($encoded, true);
    $username = $decode["username"];
    $mail = $decode["mail"];
    $password = $decode["password"];
    $address = $decode["address"];
    fwrite($f,$username);
    fwrite($f,$mail);
    fwrite($f,$password);
    fwrite($f,$address);

    $user = new User($username,$password,$mail,new DateTime(),$address);
    $idUser = $user->addEmployee();
    echo($idUser);
}catch(ERROR $e){
    fwrite($f,$e);
    echo(false);
}catch(Exception $e){
    fwrite($f,$e);
    echo(false);
}


?>