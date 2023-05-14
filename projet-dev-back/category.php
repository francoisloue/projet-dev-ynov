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
    "POST", "GET", and "DELETE", which are HTTP request methods used to interact with the server.
    Depending on the value of ``, different actions will be taken in the code. */
    switch ($request_method) {
        /* This code block is handling a POST request method. It is retrieving the data sent in the
        request body using `file_get_contents("php://input")`, decoding it using `json_decode()`,
        and assigning the value of the "categoryName" key to the `` variable. It then
        checks if a category with the same name already exists in the database using the
        `getFromDbByParam()` method of the `` object. If the category does not exist, it creates
        a new `Category` object with the `` and adds it to the database. If the
        category already exists, it returns a JSON-encoded message saying "This Category already
        exist". */
        case ("POST"):
            $encoded = file_get_contents("php://input");
            $decode = json_decode($encoded, true);
            $categoryName = $decode["categoryName"];
            if (is_null($category = $DB->getFromDbByParam("category", "name", $categoryName))) {
                $newCategory = new Category($categoryName);
            } else {
                echo(json_encode("This Category already exist"));
            }   
        /* This code block is handling a GET request method. It first checks if the length of the
        `` array is greater than 2, which means that there are additional parameters in
        the request. If the second parameter is an integer (checked using `intval()`), it retrieves
        the category with the corresponding ID from the database using the `getFromDbByParam()`
        method of the `` object and returns it as a JSON-encoded string using `json_encode()`. If
        the second parameter is not an integer, it checks if it is equal to the string "category".
        If it is, it checks if the third parameter is an integer. If it is, it retrieves all items
        in the category with the corresponding category ID from the database using the `getInDB()`
        method of the `` object and returns them as a JSON-encoded string. If the third parameter
        is not an integer, it returns a JSON-encoded error message. If the length of the
        `` array is not greater than 2, it retrieves all categories from the database
        using the `getInDB()` method of the `` object and returns them as a JSON-encoded string. */
        case ("GET"):
            if (count($request_URI)>2) {
                if (intval($request_URI[2]) != 0) {
                    echo(json_encode($DB->getFromDbByParam("category","id", intval($request_URI[2]))));
                } else {
                    switch ($request_URI[2]) {
                        case("category"):
                            if (intval($request_URI[3]) != 0) {
                                echo(json_encode($DB->getInDB("*", "category", "categoryID", $request_URI[3])));
                            } else {
                                echo json_encode($request_error);
                            }
                    }
                    
                }
            } else {
                echo(json_encode($DB->getInDB("*","category")));
            }
            break;
       /* This code block is handling a DELETE request method. It first checks if the length of the
       `` array is greater than 2, which means that there are additional parameters in
       the request. If the second parameter is an integer (checked using `intval()`), it retrieves
       all items in the category with the corresponding category ID from the database using the
       `getInDB()` method of the `DBHandler` object and deletes them from the database using the
       `delete()` method of the `DBHandler` object. It then deletes the category with the
       corresponding ID from the database using the `delete()` method of the `DBHandler` object. If
       the second parameter is not an integer, it returns a JSON-encoded false message. */
        case ("DELETE"):
            if(count($request_URI)>2){
                if(intval($request_URI[2])!=0){
                    $items=$DB->getInDB("*", "items", "categoryID", $request_URI[2]);
                    $DB->delete("category","id",$request_URI[2]);
                    foreach($items as $item) {
                        $DB->delete("items", "id", $item["id"]);
                    }
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
