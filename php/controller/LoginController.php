<?php

require_once("model/ItemDB.php");
require_once("model/ImageDB.php");
require_once("model/UserDB.php");
require_once("ViewHelper.php");

class LoginController {
    
    public static function loginForm($values = ["email" => "", "password" => ""]) {
        ViewHelper::render("view/login.php", $values);
    }
    public static function login(){
        $data = filter_input_array(INPUT_POST, self::getRules());
        $data["password"] = filter_var($data["password"],FILTER_VALIDATE_REGEXP,['options' => ['regexp' => "/^.{6,25}$/"]]);
        if(self::checkValues($data)){
            //preverimo ali vnešeni email naslov obstaja v bazi
            if(UserDB::get($data)){
                $variables = UserDB::get($data); 
                $passwd = $variables["geslo"];
                //preverimo ali je vnešeno geslo enako nastavljenemu geslu
                if(password_verify($data["password"], $passwd)){
                    session_start();
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $variables["id_uporabnika"];
                    $_SESSION["username"] = $variables["ime_uporabnika"];
                    $_SESSION["email"] = $variables["elektronski_naslov"];
                    $_SESSION["userRole"] = $variables["Vloga_id_vloge"];
                    $_SESSION["roleName"] = "";
                    //user je admin || user je prodajalec
                    if($variables["Vloga_id_vloge"] == 1 || $variables["Vloga_id_vloge"] == 2){
                        $_SESSION["roleName"] = ($variables["Vloga_id_vloge"] == 1) ? "admin/" : "seller/"; 
                        ViewHelper::redirect(BASE_URL . "authorize");
                    }
                    else{
                        $_SESSION["roleName"] = "customer/";
                        ViewHelper::redirect(BASE_URL . $_SESSION["roleName"] . "store");
                    }
                }
                //geslo ni enako nastavljenemo geslu
                else{
                    //echo "Geslo ni pravilno";
                    $passwordError = "Geslo, ki ste ga vnesli ni pravilno!";
                    ViewHelper::render("view/login.php", array("message" => $passwordError,"heading" => "Napaka"));
                }
            }
            //mail ne obstaja
            else{
                $mailError = "Uporabnika s tem email naslovom ni bilo mogoče najti!";
                ViewHelper::render("view/login.php", array("message" => $mailError,"heading" => "Napaka"));
            }
        }
        //vnosna polja niso (v celoti) izpolnjena
        else{
            $fieldsError = "Pomanjkljivo izpolnjena vnosna polja!";
            //echo "Pomanjklivo izpolnjena vnosna polja";
            ViewHelper::render("view/login.php",array("message" => $fieldsError,"heading" => "Napaka"));            
        }
    }
    public static function logout(){
        session_start();
        $_SESSION = array();
        session_destroy();
        ViewHelper::redirect(BASE_URL . "store");
    }
    
    public static function authorizeUser() {
        # preberemo odjemačev certifikat
        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");
        # in ga razčlenemo
        $cert_data = openssl_x509_parse($client_cert);
        
        $mail = $cert_data['subject']['emailAddress'];
        if($mail == $_SESSION["email"]){
            ViewHelper::redirect(BASE_URL . $_SESSION["roleName"] . "store");
        }
        else{
            $_SESSION = array();
            session_destroy();
            ViewHelper::redirect(BASE_URL . "store");
        }
        //var_dump($cert_data);
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
            'email' => [
                'filter' => FILTER_VALIDATE_EMAIL
            ],
            'password' => [
                'filter' => FILTER_SANITIZE_STRING
            ]
        ];
    }
}