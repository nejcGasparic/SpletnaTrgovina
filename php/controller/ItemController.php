<?php

require_once("model/ItemDB.php");
require_once("ViewHelper.php");

class ItemController {
    //put your code here
    
    public static function itemSettings(){
        $vars = [
            "items" => ItemDB::getAll()
        ];
        ViewHelper::render("view/item-settings.php", $vars);
    }
    public static function updateItem(){
        $rules = self::getRules();
        $data = filter_input_array(INPUT_POST,$rules);
        if(self::checkValues($data)){
            //ItemDB::update($data);
            //preverimo da se izdelek, ki ga zelimo spremeniti nahaja v bazi
            if(ItemDB::get($data)){
                //echo "Ta izdelek se nahaja v bazi";
                ItemDB::update($data);
            }
            else{
                echo "Izdelek s tem ID-jem ne obstaja";
            }
        }
        ViewHelper::redirect(BASE_URL . $_SESSION["roleName"] . "itemSettings");
    }
    public static function deactivateItem(){
       $rules["id"] = [
          'filter' => FILTER_VALIDATE_INT,
          'options' => ['min_range' => 1]
        ];
        $data = filter_input_array(INPUT_POST,$rules);
        if(self::checkValues($data)){
            ItemDB::deactivateItem($data);
        }
        ViewHelper::redirect(BASE_URL . $_SESSION["roleName"] . "itemSettings" );
    }
    public static function activateItem(){
       $rules["id"] = [
          'filter' => FILTER_VALIDATE_INT,
          'options' => ['min_range' => 1]
        ];
        $data = filter_input_array(INPUT_POST,$rules);  
        if(self::checkValues($data)){
            ItemDB::activateItem($data);
        }
        ViewHelper::redirect(BASE_URL . $_SESSION["roleName"] . "itemSettings" );
    }
    public static function createForm(){
        ViewHelper::render("view/new-item.php");
    }
    public static function create(){
        $rules = self::getRules();
        unset($rules["id"]);
        $data = filter_input_array(INPUT_POST, $rules);
        $data["name"] = filter_var($data["name"],FILTER_VALIDATE_REGEXP,['options' => ['regexp' => "/^.{4,20}$/"]]);
        if(self::checkValues($data)){
            ItemDB::insert($data);
            ViewHelper::redirect(BASE_URL .$_SESSION["roleName"]. "itemSettings");
        }
        else{
            echo "Vnosna polja niso v celoti izpolnjena!";
        }
    }    
    /**
     * Returns TRUE if given $input array contains no FALSE values
     * @param type $input
     * @return type
     */
    private static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }

        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        return $result;
    }
    /**
     * Returns an array of filtering rules for manipulation books
     * @return type
     */
    private static function getRules() {
        return [
            'name' => FILTER_SANITIZE_STRING,
            'price' => FILTER_VALIDATE_FLOAT,
            'id' => FILTER_VALIDATE_INT
        ];
    }
}
