<?php

require_once 'model/AbstractDB.php';

class ItemDB extends AbstractDB {
    
    public static function delete(array $id) {
        
    }

    public static function getForIds($ids) {
        $db = DBInit::getInstance();

        $id_placeholders = implode(",", array_fill(0, count($ids), "?"));
        $statement = $db->prepare("SELECT id_artikla, naziv_artikla, cena_artikla FROM Artikel
            WHERE id_artikla IN (" . $id_placeholders . ")");
        $statement->execute($ids);

        return $statement->fetchAll();
    }    
    
    public static function get(array $data) {
        $items = parent::query("SELECT * "
                            .  "FROM Artikel "
                            .  "WHERE id_artikla = :id ",$data);
        if(count($items) == 1){
            return $items[0];
        }
        else{
            return false;
        }
    }

    public static function getAllActive() {
        return parent::query("SELECT id_artikla, naziv_artikla, cena_artikla "
                            ."FROM Artikel "
                            ."WHERE aktiven = 1 "
                            ."ORDER BY naziv_artikla ASC");        
    }
    

    public static function getAll() {
        return parent::query("SELECT * "
                            ."FROM Artikel "
                            ."ORDER BY naziv_artikla ASC"); 
    }
    
    public static function insert(array $params) {
        return parent::modify("INSERT INTO Artikel (naziv_artikla, cena_artikla) "
                            . "VALUES (:name, :price)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Artikel SET naziv_artikla = :name, cena_artikla = :price "
                            . "WHERE id_artikla = :id",$params);
    }
    
    public static function deactivateItem($params){
        return parent::query("UPDATE Artikel SET Aktiven = 0 WHERE id_artikla = :id ",$params);
    }
    
    public static function activateItem($params){
        return parent::query("UPDATE Artikel SET Aktiven = 1 WHERE id_artikla = :id ",$params);
    }

}
