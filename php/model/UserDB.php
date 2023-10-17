<?php

require_once("model/AbstractDB.php");

class UserDB extends AbstractDB {
    
    public static function delete(array $id) {
        
    }

    public static function get(array $data) {
        $users = parent::query("SELECT * "
                             . "FROM Uporabnik "
                             . "WHERE elektronski_naslov = :email AND aktiven = 1 ",$data);
        //var_dump($users[0]);
        if(count($users) == 1){
            return $users[0];
        }
        else{
            //throw new InvalidArgumentException("Uporabnik z danim emailom ne obstaja");
            return false;
        }
    }
    
    public static function getUserWithID(array $data){
        $users = parent::query("SELECT * "
                             . "FROM Uporabnik "
                             . "WHERE id_uporabnika = :id AND aktiven = 1 ",$data);
        //var_dump($users[0]);
        if(count($users) == 1){
            return $users[0];
        }
        else{
            //throw new InvalidArgumentException("Uporabnik z danim emailom ne obstaja");
            return false;
        }
    }
    
    public static function getGroupOfUsers(array $data){
        return parent::query("SELECT * "
                             . "FROM Uporabnik " 
                             . "WHERE Vloga_id_vloge = :role", $data);
        
    }
    
    public static function deactivateUser(array $params){
        return parent::modify("UPDATE Uporabnik SET aktiven = 0 WHERE id_uporabnika = :id",$params);
    }
    public static function activateUser(array $params){
        return parent::modify("UPDATE Uporabnik SET aktiven = 1 WHERE id_uporabnika = :id",$params);
    }
    
    public static function getAll() {
        return parent::query("SELECT * FROM Uporabnik ");
    }

    public static function insert(array $params) {
        //$passwd = password_hash($params["password"],PASSWORD_DEFAULT);
        $params["role"] = (int)$params["role"];
        $params["password"] = password_hash($params["password"], PASSWORD_DEFAULT);
        return parent::modify("INSERT INTO Uporabnik (ime_uporabnika, priimek_uporabnika, elektronski_naslov, geslo, Vloga_id_vloge) "
                            . "VALUES (:name, :surname, :email, :password, :role)", $params);
    }

    public static function update(array $params) {
        //var_dump($params);
        $params["newPassword"] = password_hash($params["newPassword"], PASSWORD_DEFAULT);
        return parent::modify("UPDATE Uporabnik SET ime_uporabnika = :name, priimek_uporabnika = :surname, elektronski_naslov = :email, geslo = :newPassword "
                . "WHERE id_uporabnika = :id",$params);
    }
    
    public static function updatePassword(array $params){
        
    }

}
