<?php

require_once 'model/AbstractDB.php';

class ImageDB extends AbstractDB {
    
    public static function delete(array $id) {
        
    }

    public static function get(array $id) {
        $images = parent::query("SELECT pot_do_slike, Artikel_id_artikla "
                                ."FROM Slika "
                                ."WHERE Artikel_id_artikla = :id",$id);
        
        if(count($images) == 1){
            return $images[0];
        }else{
            throw new InvalidArgumentException("Slika s podanim ID-jem ne obstaja");
        }
    }

    public static function getAll() {
        return parent::query("SELECT pot_do_slike, Artikel_id_artikla "
                            ."FROM Slika");
    }

    public static function insert(array $params) {
        
    }

    public static function update(array $params) {
        
    }

}
