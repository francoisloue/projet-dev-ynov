<?php 
require_once "dbSetting.php";
/* The User class is a PHP class that extends a DBHandler class and has properties and methods for
adding an employee to a database. */
class User extends DBHandler{

    private string $username;
    private string $password;
    private string $mail;
    private DateTime $registrationDate;
    private string $address;
    private int $userType;


   /**
    * This is a constructor function that sets the properties of a user object with provided values,
    * including hashing the password.
    * 
    * @param string username A string representing the username of the user being created.
    * @param string password The password parameter is a string that represents the user's password. It
    * is passed to the constructor as an argument and is then hashed using the password_hash() function
    * with the PASSWORD_BCRYPT algorithm. This ensures that the password is securely stored in the
    * database and cannot be easily accessed by unauthorized users.
    * @param string mail The email address of the user.
    * @param DateTime registrationDate registrationDate is a parameter of type DateTime that represents
    * the date and time when the user registered for an account. It is used in the constructor to set
    * the registration date of the user object being created.
    * @param string address The "address" parameter in the constructor is a string that represents the
    * user's address. It could be their physical address or an email address, depending on the context
    * of the application.
    */
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