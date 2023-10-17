<?php

//enables session
session_start();

require_once("./controller/StoreController.php");
require_once ("./controller/RegisterController.php");
require_once ("./controller/LoginController.php");
require_once ("./controller/UserController.php");
require_once ("./controller/ItemController.php");

define("BASE_URL",$_SERVER["SCRIPT_NAME"]."/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";
/*
var_dump(BASE_URL);
var_dump(IMAGES_URL);
var_dump(CSS_URL);
var_dump($path);
exit();
 */
$urls = [
    "store" => function() {
        $_SESSION["roleName"] = "";
        if($_SESSION["roleName"] == ""){
            StoreController::index();
        }
        else{
            echo "Napačen url!";
        }
    },
    "customer/store" => function() {
        if($_SESSION["roleName"] == "customer/"){
            StoreController::index();
        }
        else{
            echo "Napačen url!";
        }
    },
    "customer/store/add-to-cart" => function(){
        if($_SESSION["roleName"] == "customer/"){
            StoreController::addToCart();
        }
        else{
            echo "Napačen URL";
        }
    },
    "customer/store/update-cart" => function(){
        StoreController::updateCart();
    },
    "customer/store/purge-cart" => function(){
        StoreController::purgeCart();        
    },
    "customer/invoice" => function(){
        StoreController::invoice();
    },
    "customer/purchase" => function(){
        //var_dump($_SESSION["cart"]);
        //exit;
        StoreController::completeOrder();
    },
    "customer/orders" => function(){
        StoreController::userOrders();
    },
    "admin/store" => function (){
        if($_SESSION["roleName"] == "admin/"){
            StoreController::index();
        }
        else{
            echo "Napačen url!";
        }
    },
    "seller/store" => function(){
        if($_SESSION["roleName"] == "seller/"){
            StoreController::index();
        }
        else{
            echo "Napačen url!";
        }
    },
    "seller/orders" => function(){
        StoreController::allOrders();
    },
    "confirm-order" => function(){
        StoreController::confirmOrder();
    },
    "cancel-order" => function(){
        StoreController::cancelOrder();
    },
    "terminate-order" => function(){
        StoreController::terminateOrder();
    },
    "register" => function() {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            RegisterController::register();
        }
        else{
            RegisterController::registerForm();
        }
    },
    "login" => function() {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            LoginController::login();
        }
        else{
            LoginController::loginForm();  
        }
    },
    "logout" => function (){
        LoginController::logout();
    },
    "customer/user" => function(){
        if($_SESSION["roleName"] == "customer/"){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                UserController::settings();
            }
            else{
                UserController::settingsForm();
            }            
        }
        else{
            echo "Napačen URL";
        }
    },
    "admin/user" => function(){
        if($_SESSION["roleName"] == "admin/"){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                UserController::settings();
            }
            else{
                UserController::settingsForm();
            }            
        }
        else{
            echo "Napačen URL";
        }  
    },
    "seller/user" => function(){
        if($_SESSION["roleName"] == "seller/" || $_SESSION["adminFlag"] == true){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                UserController::settings();
            }
            else{
                UserController::settingsForm();
            }            
        }
        else{
            echo "Napačen URL";
        }   
    },
    "admin/sellerSettings" => function(){
        if($_SESSION["roleName"] == "admin/"){
            UserController::sellerSettings();
        }
        else{
            echo "Napačen URL";
        }  
    },
    "admin/createUser" => function(){
        if($_SESSION["roleName"] == "admin/"){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                UserController::create();
            }
            else{
                UserController::createForm();
            }        
        }
        else{
            echo "Napačen URL";
        }          
    },
    "seller/createUser" => function(){
        if($_SESSION["roleName"] == "seller/"){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                UserController::create();
            }
            else{
                UserController::createForm();
            }        
        }
        else{
            echo "Napačen URL";
        }
    },
    "deactivate" => function () {
        if($_SESSION["roleName"] == "admin/"){
            UserController::deactivateUser();
        }
        else{
            echo "Napačen URL";
        }  
    },
    "activate" => function(){
        if($_SESSION["roleName"] == "admin/"){
            UserController::activateUser();
        }
        else{
            echo "Napačen URL";
        }          
        
    },
    "seller/customerSettings" => function() {
        if($_SESSION["roleName"] == "seller/"){
            UserController::customerSettings();
        }
        else{
            echo "Napačen URL";
        }
    },
    "seller/itemSettings" => function(){
        if($_SESSION["roleName"] == "seller/"){
            ItemController::itemSettings();
        }
        else{
            echo "Napačen URL";
        }
    },
    "seller/item" => function(){
        if($_SESSION["roleName"] == "seller/" && $_SERVER["REQUEST_METHOD"] == "POST"){
            ItemController::updateItem();
        }
        else{
            echo "Napačen URL";
        }
    },
    "seller/createItem" => function (){
        if($_SESSION["roleName"] == "seller/"){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                ItemController::create();
            }
            else{
                ItemController::createForm();
            }        
        }
        else{
            echo "Napačen URL";
        }        
        
    },
    "activateItem" => function(){
        if($_SESSION["roleName"] == "seller/"){
            ItemController::activateItem();
        }
        else{
            echo "Napačen URL";
        }            
        
    },
    "deactivateItem" => function(){
        if($_SESSION["roleName"] == "seller/"){
            ItemController::deactivateItem();
        }
        else{
            echo "Napačen URL";
        }            
        
    },
    "authorize" => function (){
        LoginController::authorizeUser();
    },
    "" => function() {
        ViewHelper::redirect(BASE_URL . "store");
    }
];

try {
    //echo $path;
    if(isset($urls[$path])){
        $urls[$path]();
    }
    else{
        echo "No controller for $path";
    }
} 
catch (InvalidArgumentException $e) {
    ViewHelper::error404();
} 
catch (Exception $exc) {
    echo "An error occurred: <pre>$exc</pre>";
}
