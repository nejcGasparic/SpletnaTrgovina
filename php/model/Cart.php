<?php
require_once("model/ItemDB.php");

class Cart {
    //put your code here
    
    public static function getAll(){
        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            return [];
        }

        $ids = array_keys($_SESSION["cart"]);
        $cart = ItemDB::getForIds($ids);

        // Adds a quantity field to each item in the list
        foreach ($cart as &$item) {
            $item["kolicina"] = $_SESSION["cart"][$item["id_artikla"]];
        }
        return $cart;        
    }
    
    
    public static function add($id) {
        $item = ItemDB::get(["id" => $id]);
        if ($item != null) {
            if (isset($_SESSION["cart"][$id])) {
                $_SESSION["cart"][$id] += 1;
            } else {
                $_SESSION["cart"][$id] = 1;
            }            
        }
    }
    
    public static function update($id, $quantity) {
        $item = ItemDB::get(["id" => $id]);
        $quantity = intval($quantity);
        if ($item != null) {
            if ($quantity <= 0) {
                unset($_SESSION["cart"][$id]);
            } else {
                $_SESSION["cart"][$id] = $quantity;
            }
        }
    }

    public static function purge() {
        unset($_SESSION["cart"]);
    }    
    
    public static function total() {
        return array_reduce(self::getAll(), function ($total, $item) {
            return $total + $item["cena_artikla"] * $item["kolicina"];
        }, 0);
    }    
}
