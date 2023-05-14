<?php
require_once ("dbSetting.php");
class Item extends DBHandler {
    private $itemName;
    private $itemDescritpion;
    private $itemPrice;
    private $itemCategoryID;
    private $itemImageURL;

    function __construct($name, $description = NULL, $price, $categoryID, $itemImageURL = NULL) 
    {
        parent::__construct();
        $this->itemName = $name;
        $this->itemDescritpion = $description;
        $this->itemPrice = $price;
        $this->itemCategoryID = $categoryID;
        $this->itemImageURL = $itemImageURL; 
        $this->pushItemInDB();
    }

    public function pushItemInDB() 
    {
        $data = array(
            "name" => $this->itemName,
            "description" => $this->itemDescritpion,
            "price" => $this->itemPrice,
            "categoryID" => $this->itemCategoryID,
            "imageURL"=> $this->itemImageURL
        );
        $checkItem = $this->getFromDbByParam("items","name", $this->itemName);
        if(empty($checkItem)) {
            $this->insert($data, "items");
            echo(json_encode("Item successfuly created"));
        } else {
            echo(json_encode("This item already exist with the ID : " . $checkItem["id"]));
        }
    }
}