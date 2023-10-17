<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");

class UserController {
    
    public static function settingsForm($user = []){
        if(empty($user)){
            $rules = [
                "id" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 1]
                ]
            ];
            $data = filter_input_array(INPUT_GET, $rules);
            if(!self::checkValues($data)){
                throw new InvalidArgumentException();
            }
            $user = UserDB::getUserWithID($data);
            //var_dump($user);
        }
        ViewHelper::render("view/user-settings.php", ["user" => $user]);
    }
    
    public static function settings(){
        $rules = self::getRules();
        $rules["id"] = [
          'filter' => FILTER_VALIDATE_INT,
          'options' => ['min_range' => 1]
        ];
        $data = filter_input_array(INPUT_POST,$rules);
        $data["email"] = filter_var($data["email"],FILTER_SANITIZE_EMAIL);
        $data["currentPassword"] = filter_var($data["currentPassword"],FILTER_VALIDATE_REGEXP,['options' => ['regexp' => "/^.{6,25}$/"]]);
        $data["newPassword"] = filter_var($data["newPassword"],FILTER_VALIDATE_REGEXP,['options' => ['regexp' => "/^.{6,25}$/"]]);
        if(self::checkValues($data)){
            $variables = UserDB::get($data); 
            //trenutno geslo
            $passwd = $variables["geslo"];
            //preverimo ali se currentPassword ujema z geslom, ki ga imamo v bazi
            if(password_verify($data["currentPassword"], $passwd)){
                //GESLI SE UJEMATA
                $_SESSION["messageHeading"] = "OBVESTILO";
                UserDB::update($data);
                if(isset($_SESSION["adminFlag"])){
                    $_SESSION["messageToUser"] = "Uspešno ste spremenili podatke prodajalca z imenom ". $data['name'];
                    ViewHelper::redirect(BASE_URL .$_SESSION["roleName"]. "sellerSettings");
                }else{
                    $_SESSION["messageToUser"] = "Uspešno ste spremenili vaše podatke";
                    ViewHelper::redirect(BASE_URL .$_SESSION["roleName"] ."user?id=". $data["id"]);
                }
            }
            //GESLI SE NE UJEMATA
            else{
                $_SESSION["messageToUser"] = "Geslo, ki ste ga vnesli ni pravilno! \n Poskusite znova.";
                $_SESSION["messageHeading"] = "NAPAKA";
                if(isset($_SESSION["adminFlag"])){
                    ViewHelper::redirect(BASE_URL .$_SESSION["roleName"]."sellerSettings");
                }else{
                    ViewHelper::redirect(BASE_URL .$_SESSION["roleName"]."user?id=". $data["id"]);
                }
            }
        }
        else{
            self::settingsForm();
        }
    }
    public static function sellerSettings(){
        $vars = [
          "sellers" => UserDB::getGroupOfUsers(["role" => 2])  
        ];
        //var_dump($vars);
        //exit;
        ViewHelper::render("view/seller-settings.php",$vars);
    }
    
    public static function customerSettings(){
        $vars = [
            "customers" => UserDB::getGroupOfUsers(["role" => 3])
        ];
        ViewHelper::render("view/customer-settings.php", $vars);
    }
    public static function deactivateUser(){
        $rules["id"] = [
          'filter' => FILTER_VALIDATE_INT,
          'options' => ['min_range' => 1]
        ];
        $data = filter_input_array(INPUT_POST,$rules);
        if(self::checkValues($data)){
            UserDB::deactivateUser($data);
        }
        ViewHelper::redirect(BASE_URL . $_SESSION["roleName"]. "sellerSettings");
        
    }
    public static function activateUser(){
        $rules["id"] = [
          'filter' => FILTER_VALIDATE_INT,
          'options' => ['min_range' => 1]
        ];
        $data = filter_input_array(INPUT_POST,$rules);
        if(self::checkValues($data)){
            UserDB::activateUser($data);
        }
        ViewHelper::redirect(BASE_URL . $_SESSION["roleName"]. "sellerSettings");
    }
    public static function createForm(){
        //echo "Hello";
        ViewHelper::render("view/new-user.php");
    }
    public static function create(){
        $rules = self::getRules();
        $rules["role"] = ["filter" => FILTER_VALIDATE_INT];
        unset($rules["currentPassword"]);
        unset($rules["newPassword"]);
        $rules["password"] = ["filter" => FILTER_SANITIZE_STRING];
        $data = filter_input_array(INPUT_POST,$rules);
        $data["email"] = filter_var($data["email"],FILTER_SANITIZE_EMAIL);
        $data["password"] = filter_var($data["password"],FILTER_VALIDATE_REGEXP,['options' => ['regexp' => "/^.{6,25}$/"]]);
        if(self::checkValues($data)){
                //uporabnik s tem email naslovom že obstaja v naši bazi
                if(UserDB::get($data)){
                    //$_SESSION["newSellerPassword"] = "Prodajalec s tem email naslovom že obstaja!";
                    ViewHelper::redirect(BASE_URL .$_SESSION["roleName"]."createUser");
                }
                //uporabnik s tem email naslovom ne obstaja v nasi bazi zato lahko zapis dodamo v bazo
                else{
                    UserDB::insert($data);
                    if($_SESSION["roleName"] == "admin/"){
                        ViewHelper::redirect(BASE_URL .$_SESSION["roleName"]. "sellerSettings");
                    }
                    else if($_SESSION["roleName"] == "seller/"){
                        ViewHelper::redirect(BASE_URL .$_SESSION["roleName"]. "customerSettings");
                    }
                }
        }
        //vnosna polja niso v celoti izpolnjena
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
            'surname' => FILTER_SANITIZE_STRING,
            'email' => [
                'filter' => FILTER_VALIDATE_EMAIL 
            ],
            'currentPassword' => [
                'filter' => FILTER_SANITIZE_STRING,
            ],
            'newPassword' => [
                'filter' => FILTER_SANITIZE_STRING,
            ]
        ];
    }
}

