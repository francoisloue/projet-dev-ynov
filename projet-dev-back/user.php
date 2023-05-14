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
    /* The `switch ()` statement is checking the value of the `` variable
    and executing the corresponding case statement. In this code, it is used to handle different
    HTTP request methods (POST, GET, PUT) and execute different code blocks accordingly. */
    switch ($request_method) {
        /* This code block is handling the HTTP POST request method. It first reads the input data from
        the request body using `file_get_contents("php://input")` and then decodes the JSON data
        using `json_decode(, true)`. It then checks if the request URI has more than two
        parts and if the second part is not an integer. If it is not an integer, it checks the value
        of the second part and executes the corresponding case statement. In this code, it is
        checking if the second part is either "login" or "register". If it is "login", it retrieves
        the user data from the database based on the email provided in the request body and checks
        if the password matches using `password_verify()`. If it is "register", it creates a new
        user object and adds it to the database using the `addEmployee()` method. Finally, it echoes
        the result of the operation. */
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
        /* This code block is handling the HTTP GET request method. It first checks if the request URI
        has more than two parts and if the second part is not an integer. If it is not an integer,
        it checks the value of the second part and executes the corresponding case statement. In
        this code, it is checking if the second part is either an ID of a user or "userType". If it
        is an ID of a user, it retrieves the user data from the database based on the ID provided in
        the request URI and echoes the result in JSON format. If it is "userType", it checks if
        there is a third part in the request URI. If there is, it retrieves the user type data from
        the database based on the ID provided in the third part of the request URI and echoes the
        result in JSON format. If there is no third part, it retrieves all user type data from the
        database and echoes the result in JSON format. If the request URI has only two parts, it
        retrieves all user data from the database and echoes the result in JSON format. */
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
        /* This code block is handling the HTTP PUT request method. It first reads the input data from
        the request body using `file_get_contents("php://input")` and then decodes the JSON data
        using `json_decode(, true)`. It then checks if the request URI has more than two parts and
        if the second part is "changeType". If it is "changeType", it retrieves the user ID and user
        type from the decoded JSON data and updates the user type in the database using the
        `updateInDB()` method. Finally, it echoes `true` to indicate that the operation was
        successful. */
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
