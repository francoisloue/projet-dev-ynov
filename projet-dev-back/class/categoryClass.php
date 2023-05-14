<?php
require_once ("dbSetting.php");
require_once ("./header.php");
/* The Category class extends a DBHandler class and has a constructor that takes a name parameter and
pushes it into a database table called "category". It's used to create new categories */
class Category extends DBHandler {
    private $itemName;

    function __construct($name) 
    {
        parent::__construct();
        $this->itemName = $name;
        $this->pushItemInDB();
    }

    public function pushItemInDB() 
    {
        $data = array(
            "name" => $this->itemName,
        );
        $this->insert($data, "category");
    }
}