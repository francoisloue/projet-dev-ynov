<?php
try {
    header('Content-type: text/javascript');
    require_once("class/dbSetting.php");
    require_once("class/newItem.php");
    require_once("class/categoryClass.php");
    require_once("./header.php");

    $DB = new DBHandler();
    
    $request_error = "You've got a wrong id or research";
    $request_URI = $_SESSION["request"];
    $request_method = $_SERVER["REQUEST_METHOD"];
    /* The `switch ()` statement is checking the value of the `` variable
    and executing the corresponding case statement. The possible values for `` are
    "POST", "GET", and "DELETE". */
    switch ($request_method) {
        /* This code block is handling the HTTP POST request method. It is receiving data from the
        client-side in JSON format, decoding it, and creating a new `Item` object with the decoded
        data. The `Item` object is then stored in the database, and a success message is returned to
        the client-side in JSON format. */
        case ("POST"):
            $encoded = file_get_contents("php://input");
            $decode = json_decode($encoded, true);
            $itemName = $decode["itemName"];
            $itemDescription = null;
            if ($decode["itemDescription"] != "") {
                $itemDescription = $decode["itemDescription"];
            }
            if ($decode["itemImageURL"]!= "") {
                $itemIllustration = $decode["itemImageURL"];
            } else {
                $itemIllustration = "https://cdn0.iconfinder.com/data/icons/cosmo-layout/40/box-512.png";
            }
            $itemCategory=$decode["itemCategory"];
            $itemPrice = $decode["itemPrice"];
            $newItem = new Item($itemName, $itemDescription, $itemPrice, $itemCategory, $itemIllustration);
            echo(json_encode("Item created successfully"));
        /* This code block is handling the HTTP GET request method. It is checking the length of the
        `` array to determine if any parameters have been passed in the URL. If there
        are parameters, it checks the value of the second parameter (`[2]`) to determine
        if it is an ID or a category. If it is an ID, it retrieves the item with that ID from the
        database using the `getFromDbByParam()` method of the `DBHandler` class and returns it to
        the client-side in JSON format. If it is a category, it retrieves all items in that category
        from the database using the `getInDB()` method of the `DBHandler` class and returns them to
        the client-side in JSON format. If the second parameter is not an ID or a category, it
        returns an error message in JSON format. If there are no parameters, it retrieves all items
        from the database using the `getInDB()` method of the `DBHandler` class and returns them to
        the client-side in JSON format. */
        case ("GET"):
            if (count($request_URI)>2) {
                if (intval($request_URI[2]) != 0) {
                    echo(json_encode($DB->getFromDbByParam("items","id", intval($request_URI[2]))));
                } else {
                    switch ($request_URI[2]) {
                        case("category"):
                            if (intval($request_URI[3]) != 0) {
                                echo(json_encode($DB->getInDB("*", "items", "categoryID", $request_URI[3])));
                            } else {
                                echo json_encode($request_error);
                            }
                            break;
                        case("randomCategory"):
                            if (intval($request_URI[3]) != 0) {
                                echo(json_encode($DB->getAllRandomn(5, $request_URI[3])));
                            } else {
                                echo json_encode($request_error);
                            }
                            break;
                    }
                    
                }
            } else {
                echo(json_encode($DB->getInDB("*","items")));
            }
            break;
        /* This code block is handling the HTTP DELETE request method. It is checking if there are any
        parameters passed in the URL and if the second parameter is an ID. If it is an ID, it calls
        the `delete()` method of the `DBHandler` class to delete the item with that ID from the
        database and returns `true` to the client-side in JSON format. If the second parameter is
        not an ID, it returns `false` to the client-side in JSON format. If there are no parameters,
        it breaks out of the switch statement. */
        case "DELETE":
            if(count($request_URI)>2){
                if(intval($request_URI[2])!=0){
                    $DB->delete("items","id",$request_URI[2]);
                    echo(true);
                    break;
                } else {
                    echo(false);
                    break;
                }
            }
            break;
    }
} catch(ERROR $e){
    echo false;
} catch(Exception $e){
    echo false;
}
