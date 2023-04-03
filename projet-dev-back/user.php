<?php
$f = fopen("test.txt","w");
try{
    header('Content-type: text/javascript');
    require_once("class/dbSetting.php");
    require_once("class/user.php");
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
                            break;

                        case("register"):
                            $username = $decode["username"];
                            $mail = $decode["mail"];
                            $password = $decode["password"];
                            $address = $decode["address"];
                            $user = new User($username,$password,$mail,new DateTime(),$address);
                            $idUser = $user->addEmployee();
                            echo($idUser);
                            break;

                        case("changeType"):
                            $userId = $decode["userId"];
                            $userType = $decode["userType"];
                            $db = new DBHandler();
                            $db->updateInDB("user","userType",$userType,"id",$userId);
                            echo(true);
                            break;

                    }
                }
            }
        case "GET":
            if(count($request_URI)>2){
                if (intval($request_URI[2]) != 0){
                    $result = $DB->getInDB("*","user","id",$request_URI[2]);
                    if(count($result)>0){
                        echo(json_encode($result));
                    }else{
                        echo("No user with this ID found");
                    }
                }else{
                    switch($request_URI[2]){
                        case "userType":
                            if(count($request_URI)>3){
                                $result = $DB->getInDB("*","usertype","id",$request_URI[3]);
                                if(intval($request_URI[3])!=0){
                                    echo(json_encode($result));
                                }else{
                                    echo("No userType with this ID");
                                }
                            }else{
                                echo(json_encode($DB->getInDB("*","usertype")));
                            }
                    }
                }
            }else{
                echo(json_encode($DB->getInDB("*","user")));
            }
        }
}catch(ERROR $e){
    fwrite($f,$e);
    echo "error";
}catch(Exception $e){
    fwrite($f,$e);
    echo "error";
}
