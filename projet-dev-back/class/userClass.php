<?php 
require_once "dbSetting.php";
class User extends DBHandler{

    private string $username;
    private string $password;
    private string $mail;
    private DateTime $registrationDate;
    private string $address;
    private int $userType;


    function __construct(string $username,string $password,string $mail,DateTime $registrationDate, string $address)
    {
        parent::__construct();
        $this->mail = $mail;
        $this->username = $username;
        $this->address = $address;
        $this->password = password_hash($password,PASSWORD_BCRYPT);
        $this->registrationDate = $registrationDate;
    }
    function addEmployee(){
        $arrayData = [
            "username" => $this->username,
            "mail"=> $this->mail,
            "password" => $this->password,
            "address" => $this->address,
            "registrationDate" => date_format($this->registrationDate, 'Y-m-d'),
        ];
        $idUSer = $this->insert($arrayData,"user");
        return $idUSer;
    }
}

?>