<?php

require_once("model/AbstractDB.php");

class OrderDB extends AbstractDB{
    //put your code here
    public static function delete(array $id) {
        
    }

    public static function get(array $id) {
        //var_dump($id);
        return parent::query("select količina, naziv_artikla, cena_artikla from Artikel_Naročilo A left join Artikel B on A.Artikel_id_artikla = B.id_artikla where A.Naročilo_id_naročila = :order_id",$id);
    }

    public static function getAll() {
        return parent::query("SELECT * FROM Naročilo");
    }
    
    public static function getAllOrdersOfUser(array $params){
        return parent::query("SELECT * FROM Naročilo WHERE Uporabnik_id_uporabnika = :user_id",$params);
    }
    public static function insertItem(array $params) {
        //var_dump($params);
        return parent::modify("INSERT INTO Artikel_Naročilo (Artikel_id_artikla, Naročilo_id_naročila, količina) " 
                             ."VALUES (:item_id, :order_id, :quantity)",$params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Naročilo SET Status_id_statusa = :status WHERE id_naročila = :id",$params);
    }
    
    public static function getNextID(){
        $orders = parent::query("SELECT MAX(id_naročila) AS 'maxID' FROM Naročilo");
        if(count($orders) == 1){
            return $orders[0];
        }else{
            return false;
        }
    }
    public static function insert(array $params) {
        return parent::modify("INSERT INTO Naročilo(cena, Uporabnik_id_uporabnika, Status_id_statusa) "
                            . "VALUES(:total, :user_id, 1)",$params);
    }

}
