<?php
try{
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
            if (count($request_URI)>2){
                if (intval($request_URI[2]) != 0) {
                    echo("can't acces to all users buddy");
                }else{
                    switch($request_URI[2]){
                        case("login"):
                            $mail = $decode["mail"];
                            $password = $decode["password"];
                            $db = new DBHandler();
                            $data = $db->getInDB("password,userType,id","user","mail",$mail)[0];
                            if(password_verify($password,$data["password"])){
                                echo($data["id"]);
                            }else{
                                echo("false");
                            }
                        case("register"):
                            $username = $decode["username"];
                            $mail = $decode["mail"];
                            $password = $decode["password"];
                            $address = $decode["address"];
                            $user = new User($username,$password,$mail,new DateTime(),$address);
                            $idUser = $user->addEmployee();
                            echo($idUser);
                        case("changeType"):
                            $userId = $decode["userId"];
                            $userType = $decode["userType"];
                            $db = new DBHandler();
                            $db->updateInDB("user","userType",$userType,"id",$userId);
                            echo(true);
                    }
                }
            }
        }
}catch(ERROR $e){
    echo "error";
}catch(Exception $e){
    echo "error";
}
