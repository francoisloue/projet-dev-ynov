<?php
require_once ("dbSetting.php");
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