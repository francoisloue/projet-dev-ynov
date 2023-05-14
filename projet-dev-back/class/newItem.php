<?php
require_once ("dbSetting.php");
/* The Item class is a PHP class that represents an item with its name, description, price, category
ID, and image URL, and it automatically pushes the item into a database upon instantiation. */
class Item extends DBHandler {
    private $itemName;
    private $itemDescritpion;
    private $itemPrice;
    private $itemCategoryID;
    private $itemImageURL;

    /**
     * This is a constructor function that initializes properties of an item object and pushes it into
     * a database.
     * 
     * @param name The name of the item being constructed.
     * @param description The  parameter is an optional parameter that can be passed to the
     * constructor of a class. It is used to provide a description of the item being created. If no
     * description is provided, the value of the parameter will be NULL.
     * @param price The price parameter is the cost of the item being created. It is a required
     * parameter and must be provided when creating a new instance of the class.
     * @param categoryID categoryID is a variable that represents the ID of the category to which the
     * item belongs. It is used to categorize items and group them together for easier management and
     * organization.
     * @param itemImageURL The itemImageURL parameter is an optional parameter that represents the URL
     * of the image associated with the item. If provided, it will be stored in the object's property
     *  and used when displaying the item's image on the website or in other applications.
     * If not provided, the property will
     */
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

    /**
     * This function pushes an item's data into a database table and checks if the item already exists.
     */
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