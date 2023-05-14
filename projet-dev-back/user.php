<?php
try{
    header('Content-type: text/javascript');
    require_once("class/dbSetting.php");
    require_once("class/userClass.php");
    require_once("class/categoryClass.php");
    require_once("./header.php");

    $DB = new DBHandler();
    $request_error = "You've got a wrong id or research";
    $request_URI = $_SESSION["request"];
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case "POST":
            $encoded = file_get_contents("php://input");
            $decode = json_decode($encoded, true);
            if (count($request_URI)>2){
                if (intval($request_URI[2]) != 0) {
                }else{
                    switch($request_URI[2]){
                        case("login"):
                            $mail = $decode["mail"];
                            $password = $decode["password"];
                            $db = new DBHandler();
                            $data = $db->getInDB("*","user","mail",$mail);
                            if(count($data)>0){
                                if(password_verify($password,$data[0]["password"])){
                                    echo($data[0]["id"]);
                                    break;
                                }else{
                                    echo("false");
                                    break;
                                }
                            }else{
                                echo("false");
                            }
                            break;

                        case("register"):
                            $username = $decode["username"];
                            $mail = $decode["mail"];
                            $password = $decode["password"];
                            $address = $decode["address"];
                            $user = new User($username,$password,$mail,new DateTime(),$address);
                            $idUser = $user->addEmployee();
                            echo(true);
                            break;
                    }
                }
            }
            break;
        case "GET":
            if(count($request_URI)>2){
                if (intval($request_URI[2]) != 0){
                    $result = $DB->getInDB("*","user","id",$request_URI[2]);
                    if(count($result)>0){
                        echo(json_encode($result[0]));
                        break;
                    }else{
                        echo("No user with this ID found");
                        break;
                    }
                }else{
                    switch($request_URI[2]){
                        case "userType":
                            if(count($request_URI)>3){
                                $result = $DB->getInDB("*","usertype","id",$request_URI[3]);
                                if(intval($request_URI[3])!=0){
                                    echo(json_encode($result));
                                    break;
                                }else{
                                    echo("No userType with this ID");
                                    break;
                                }
                            }else{
                                echo(json_encode($DB->getInDB("*","usertype")));
                                break;
                            }
                    }
                }
            }else{
                echo(json_encode($DB->getInDB("*","user")));
                break;
            }
            break;
        case "PUT" :
            $encoded = file_get_contents("php://input");
            $decode = json_decode($encoded, true);
            if(count($request_URI)>2){
                switch($request_URI[2]){
                    case "changeType":
                        $userId = $decode["userId"];
                        $userType = $decode["userType"];
                        $db = new DBHandler();
                        $db->updateInDB("user","userType",$userType,"id",$userId);
                        echo(true);
                        break;
                }
            }
        }
}catch(ERROR $e){
    echo "error: ". $e;
}catch(Exception $e){
    echo "error: ".$e;
}
