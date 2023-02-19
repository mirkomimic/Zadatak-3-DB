<?php

require_once __DIR__ . "/db.php";

if(!isset($_SESSION['logged_user'])) {
  header("Location: view/login.php");
} else {
  $user = $_SESSION['logged_user'];
  try {
    if($user->type == "Customer") {
      $customer = new Model\Customer($user->id, $user->firstname, $user->lastname, $user->address, $user->email, $user->password, $user->type);
      include "view/header.php";
      include "view/customer.php";
      exit();
    } else if ($user->type == "Delivery Service") {
      $delivery_service = new Model\DeliveryService($user->id, $user->firstname, $user->lastname, $user->address, $user->email, $user->password, $user->type);
      include "view/header.php";
      include "view/deliveryService.php";
      exit();
    } else if($user->type == "Restaurant") {
      $restaurant = new Model\Restaurant($user->id, $user->name, $user->address, $user->email, $user->password, $user->type);
      include "view/header.php";
      include "view/restaurant.php";
      exit();
    } 
    // else {
    //   echo "Error";
    // }
  } catch(Exception $e) {
    echo "Error loggin in." . $e->getMessage();
  }

}






?>