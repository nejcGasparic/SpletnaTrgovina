<?php

require_once("model/ItemDB.php");
require_once("model/Cart.php");
require_once("model/ImageDB.php");
require_once("model/OrderDB.php");
require_once("ViewHelper.php");

class StoreController {
    
    public static function index() {
        $vars = [
            "items" => ItemDB::getAllActive(),
            "cart" => Cart::getAll(),
            "total" => Cart::total()
        ];
        ViewHelper::render("view/store-index.php", $vars);
    }
    public static function addToCart(){
        $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;
        if ($id !== null) {
            Cart::add($id);
        }
        ViewHelper::redirect(BASE_URL .$_SESSION["roleName"] . "store");        
    }
    public static function updateCart(){
        $id = (isset($_POST["id"])) ? intval($_POST["id"]) : null;
        $quantity = (isset($_POST["quantity"])) ? intval($_POST["quantity"]) : null;
        if ($id !== null && $quantity !== null) {
            Cart::update($id, $quantity);
        }

        ViewHelper::redirect(BASE_URL .$_SESSION["roleName"] . "store");        
    }
    public static function purgeCart() {
        Cart::purge();

        ViewHelper::redirect(BASE_URL .$_SESSION["roleName"] . "store");
    }
    public static function invoice(){
        $vars = [
            "items" => ItemDB::getAllActive(),
            "cart" => Cart::getAll(),
            "total" => Cart::total()
        ];        
        ViewHelper::render("view/invoice.php",$vars);
    }
    public static function completeOrder(){
        //echo "Hello";
        $vars = [
            "total" => Cart::total()
        ];     
        $newOrderID = OrderDB::insert(["total" => $vars["total"],"user_id" => $_SESSION["id"]]);
        //var_dump($newOrderID);
        //exit;
        foreach ($_SESSION["cart"] as $id => $quantity) {
            OrderDB::insertItem(["order_id" => $newOrderID,"item_id" => $id, "quantity" => $quantity]);
        }
        self::purgeCart();
    }
    public static function userOrders(){
        $vars = [
            "orders" => OrderDB::getAllOrdersOfUser(["user_id" => $_SESSION["id"]]),
            
        ];
        for ($i = 0; $i < sizeof($vars["orders"]);$i++){
            //var_dump($vars["orders"][$i]);
            $vars["orders"][$i]["items"] = OrderDB::get(["order_id" => $vars["orders"][$i]["id_naročila"]]);
            //var_dump($vars["orders"][$i]["items"]);
            //exit;
        }
        //var_dump($vars["orders"][0]);
        //exit;
        ViewHelper::render("view/order-list.php",$vars);
    }
    public static function allOrders(){
        $vars = [
            "orders" => OrderDB::getAll()
        ];
        for ($i = 0; $i < sizeof($vars["orders"]);$i++){
            //var_dump($vars["orders"][$i]);
            $vars["orders"][$i]["items"] = OrderDB::get(["order_id" => $vars["orders"][$i]["id_naročila"]]);
            //var_dump($vars["orders"][$i]["items"]);
            //exit;
        }
        //var_dump($vars["orders"][0]);
        //exit;
        ViewHelper::render("view/orders.php",$vars);        
    }
    public static function confirmOrder(){
        //echo "Hello Nejc";
        $data = filter_input_array(INPUT_POST);
        $data["id"] = (int)$data["id"];
        $data["status"] = 2;
        OrderDB::update($data);
        self::allOrders();
    }
    public static function cancelOrder(){
        //echo "Hello Nejc";
        $data = filter_input_array(INPUT_POST);
        $data["id"] = (int)$data["id"];
        $data["status"] = 3;
        OrderDB::update($data);
        self::allOrders();
    }
    public static function terminateOrder(){
        //echo "Hello Nejc";
        $data = filter_input_array(INPUT_POST);
        $data["id"] = (int)$data["id"];
        $data["status"] = 4;
        OrderDB::update($data);
        self::allOrders();
    }
}