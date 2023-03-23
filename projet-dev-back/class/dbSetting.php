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
        $stmt = $con->prepare($sql);
        if (($stmt = $con->prepare($sql))) {
            $stmt->execute();
        } else {
            error_reporting(E_ALL);
            echo "there has been an issue with : " . $sql . " " . mysqli_error($con);
        }
        mysqli_close($con);
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
}