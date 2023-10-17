<?php

require_once("model/ItemDB.php");
require_once("model/ImageDB.php");
require_once("model/UserDB.php");
require_once("ViewHelper.php");

class RegisterController {
    
    public static function registerForm($values = ["name" => "", "surname" => "", "email" => "", "password" => ""]) {
        ViewHelper::render("view/register.php",$values);
    }
    public static function register() {
        $data = filter_input_array(INPUT_POST, self::getRules());
        $data["email"] = filter_var($data["email"],FILTER_SANITIZE_EMAIL);
        $data["password"] = filter_var($data["password"],FILTER_VALIDATE_REGEXP,['options' => ['regexp' => "/^.{6,25}$/"]]);
        if(self::checkValues($data)){
            //preverimo ali ze obstaja uporabnik z vnesenim mailom
            if(UserDB::get($data)){
                //echo "Uporabnik s tem email-om že obstaja!";
                $userError = "Uporabnik s tem email-om že obstaja!";
                ViewHelper::render("view/register.php",array("errorMessage" => $userError));
            }
            //uporabnik je vnesel nov mail, ki ga se nimamo v bazi
            else{
                //var_dump($data);
                $userSuccess = "Uspešno ste se registrirali!\nSedaj se lahko prijavite v vaš novo ustvarjen račun.";
                UserDB::insert($data);
                ViewHelper::render("view/login.php", array("message" => $userSuccess,"heading" => "Obvestilo"));
                //echo "Uspeh";
                //ViewHelper::redirect(BASE_URL . "store");
            }
        }
        //vnosna polja niso (v celoti) izopolnjena
        else{
            //var_dump($data);
            $fieldsError = "Pomanjkljivo izpolnjena vnosna polja!";
            //echo "Pomanjklivo izpolnjena vnosna polja";
            ViewHelper::render("view/register.php",array("errorMessage" => $fieldsError));
            
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
            'password' => [
                'filter' => FILTER_SANITIZE_STRING,
            ],
            'role' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => [
                    'regexp' => "/[3]/"
                ]
            ]
        ];
    }
}