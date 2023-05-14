<?php
class DBHandler
{
    private $name;
    private $user;
    private $password;
    private $host;

    function __construct()
    {
        $this->name = 'projet-dev-bdd';
        $this->user = 'root';
        $this->password = '';
        $this->host = 'localhost';
    }

    public function connect()
    {
        try {
            $link = mysqli_connect($this->host, $this->user, $this->password, $this->name);
        } catch (Exception $e) {
            echo $e;
            die("Couldn't connect to db");
        }
        return $link;
    }

    public function insert(array $data, string $table)
    {
        $con = $this->connect();
        if ($con == false) {
            die("ERROR : couldn't connect properly to database : " . mysqli_connect_error());
        }
        $columns = array_keys($data);
        $values = array_values($data);
        $sql = "INSERT INTO $table (" . implode(',', $columns) . ") VALUES (\"" . implode("\", \"", $values) . "\" )";
        error_log($sql);
        $stmt = $con->prepare($sql);
        if (($stmt = $con->prepare($sql))) {
            $stmt->execute();
        } else {
            error_reporting(E_ALL);
            echo "there has been an issue with : " . $sql . " " . mysqli_error($con);
        }
        $idCreateObject = $con->insert_id;
        mysqli_close($con);
        return $idCreateObject;
    }

    public function getFromDbByParam(string $table, string $param, string $condition)
    {
        $con = $this->connect();
        if ($con == false) {
            die("ERROR : couldn't connect properly to database : " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM " . $table . " WHERE " . $param . " = '" . $condition . "'";
        if ($request = $con->prepare($sql)) {
            $request->execute();
            $result = $request->get_result();
        } else {
            die("Can't prepare the sql request properly : " . $sql . " " . mysqli_error($con));
        }
        mysqli_close($con);
        return $result->fetch_assoc();
    }

    public function getInDB(string $toSelect, string $table, string $rowToSearch = null, string|int $condition = null)
    {
        $db = $this->connect();
        $query = "";
        if (is_null($rowToSearch)) $query = "SELECT $toSelect FROM `$table`";
        else $query = "SELECT $toSelect FROM `$table` WHERE $rowToSearch = ?";
        $sql = $db->prepare($query);
        if (is_null($rowToSearch)) $sql->execute();
        else $sql->execute([$condition]);
        $resultQuery = $sql->get_result();
        $arrayData = [];
        while ($row = mysqli_fetch_assoc($resultQuery)) array_push($arrayData, $row);
        mysqli_close($db);
        return $arrayData;
    }

    public function updateInDB(string $table, string $rowToUpdate, mixed $newValue, string $tableCondition, string $condition)
    {
        $db = $this->connect();
        $sql = $db->prepare("UPDATE `$table` SET `$rowToUpdate` = $newValue WHERE $tableCondition = ?;");
        echo("UPDATE `$table` SET `$rowToUpdate` = $newValue WHERE $tableCondition = $condition");
        $sql->execute([$condition]);
        mysqli_close($db);
    }

    public function getAllRandomn(int $quantity,int $idCategory){
        $db = $this->connect();
            $sql = $db->prepare("
            SELECT * FROM items  
            WHERE categoryID = $idCategory  
            ORDER BY RAND ( )  
            LIMIT $quantity
            ");
        $sql->execute();
        $resultQuery = $sql->get_result();
        $arrayData = [];
        while($row = mysqli_fetch_assoc($resultQuery))array_push($arrayData,$row);
        mysqli_close($db) ;
        return $arrayData;
    }

    public function delete(string $table, string $rowToSearch,string $condition){
        $db = $this->connect();
        $stmt = $db->prepare("DELETE FROM $table WHERE $rowToSearch = ?");
        $stmt->execute([$condition]);
        mysqli_close($db) ;
    }

    public function getCartItems(int $idUser){
        $db = $this->connect();
        $sql = $db->prepare("
        SELECT items.name, itemscart.productID, itemscart.quantity, items.price, items.imageURL,itemscart.id 
        FROM itemscart 
        INNER JOIN items 
        ON itemscart.productID = items.id
        WHERE itemscart.userID = $idUser
        ");
        $sql->execute();
        $resultQuery = $sql->get_result();
        $arrayData = [];
        while($row = mysqli_fetch_assoc($resultQuery))array_push($arrayData,$row);
        mysqli_close($db) ;
        return $arrayData;
    }
}
