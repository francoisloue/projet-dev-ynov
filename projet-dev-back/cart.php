<?php
$f = fopen("test.txt","w");
try {
    header('Content-type: text/javascript');
    require_once("class/dbSetting.php");
    require_once("./header.php");

    $DB = new DBHandler();
    
    $request_error = "You've got a wrong id or research";
    $request_URI = $_SESSION["request"];
    $request_method = $_SERVER["REQUEST_METHOD"];
   /* The `switch ()` statement is checking the value of the `` variable
   and executing the corresponding case statement. It is used to handle different HTTP request
   methods such as GET, POST, PUT, and DELETE. Depending on the request method, different actions
   are taken such as inserting data into a database, updating data, retrieving data, or deleting
   data. */
    switch ($request_method) {
        /* This code block is handling a POST request method. It is retrieving data from the request
        body using `file_get_contents("php://input")` and decoding it using `json_decode()`. It then
        extracts the `idUser`, `idItem`, and `quantity` values from the decoded data and creates an
        associative array `` with these values. It then inserts this data into the `itemscart`
        table in the database using the `insert()` method of the `DBHandler` class and returns the
        ID of the inserted row. */
        case ("POST"):
            $encoded = file_get_contents("php://input");
            $decode = json_decode($encoded, true);
            $idUser = $decode["idUser"];
            $idItem = $decode["idItem"];
            $quantity = $decode["quantity"];
            $data = array(
                "userID" => $idUser,
                "productID" => $idItem,
                "quantity" =>$quantity,
            );
            $idCartItem = $DB->insert($data,"itemscart");
            echo($idCartItem);
            break;

            
        /* This code block is handling a PUT request method. It is checking if the length of the
        `request_URI` array is greater than 3 and if the third element is an integer. If these
        conditions are met, it is checking the value of the second element of the `request_URI`
        array. If it is equal to "addOne", it is updating the `quantity` field of the `itemscart`
        table in the database by adding 1 to the current value for the row with the `id` equal to
        the fourth element of the `request_URI` array. If it is equal to "removeOne", it is checking
        if the current value of the `quantity` field for the row with the `id` equal to the fourth
        element of the `request_URI` array is equal to 1. If it is, it is deleting the row from the
        `itemscart` table in the database. If it is not, it is updating the `quantity` field of the
        `itemscart` table in the database by subtracting 1 from the current value for the row with
        the `id` equal to the fourth element of the `request_URI` array. */
        case("PUT"):
            if (count($request_URI)>3) {
                if (intval($request_URI[3]) != 0) {
                    echo(json_encode($request_URI));
                    if($request_URI[2]=="addOne"){
                        echo("addOne");
                        $DB->updateInDB("itemscart","quantity","`quantity`+1","id",$request_URI[3]);
                        break;
                    }else if($request_URI[2]=="removeOne"){
                        if($DB->getInDB("quantity","itemscart","id",$request_URI[3])[0]["quantity"]==1){
                            $DB->delete("itemscart","id",$request_URI[3]);
                            break;
                        }else{
                            $DB->updateInDB("itemscart","quantity","`quantity`-1","id",$request_URI[3]);
                            break;
                        }
                    }else{
                        echo($request_error);
                    }
                } else {
                    echo($request_error);
                }
            } else {
                echo($request_error);
            }
            break;


        /* This code block is handling a GET request method. It is checking if the length of the
        `request_URI` array is greater than 2 and if the third element is an integer. If these
        conditions are met, it is calling the `getCartItems()` method of the `DBHandler` class with
        the third element of the `request_URI` array as an argument. This method retrieves all the
        items in the cart for the user with the specified ID from the `itemscart` table in the
        database and returns them as an array. This array is then encoded as a JSON string using
        `json_encode()` and echoed to the client. If the third element of the `request_URI` array is
        not an integer or if the length of the `request_URI` array is less than or equal to 2, an
        error message is echoed to the client. */
        case ("GET"):
            if (count($request_URI)>2) {
                if (intval($request_URI[2]) != 0) {
                    echo(json_encode($DB->getCartItems($request_URI[2])));
                } else {
                    echo($request_error);
                }
            } else {
                echo($request_error);
            }
            break;
        /* This code block is handling a DELETE request method. It is checking if the length of the
        `request_URI` array is greater than 2 and if the third element is an integer. If these
        conditions are met, it is calling the `delete()` method of the `DBHandler` class with the
        value of the third element of the `request_URI` array as the value of the `id` parameter and
        the string "itemscart" as the value of the `table` parameter. This method deletes the row
        with the specified `id` from the `itemscart` table in the database. If the deletion is
        successful, it echoes the boolean value `true`. If the third element of the `request_URI`
        array is not an integer or if the length of the `request_URI` array is less than or equal to
        2, an error message is echoed to the client. */
        case("DELETE"):
            if (count($request_URI)>2) {
                if (intval($request_URI[2]) != 0) {
                    $DB->delete("itemscart","id",$request_URI[2]);
                    echo(true);
                } else {
                    echo($request_error);
                }
            } else {
                echo($request_error);
            }
            break;
    }
} catch(ERROR $e){
    fwrite($f,$e);
    echo false;
} catch(Exception $e){
    fwrite($f,$e);
    echo false;
}
