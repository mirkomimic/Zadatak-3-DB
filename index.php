<?php

require_once __DIR__ . "/db.php";

if(!isset($_SESSION['logged_user'])) {
  header("Location: view/login.php");
} else {
  $user = $_SESSION['logged_user'];
  include "view/header.php";

  if(get_class($user) == "Model\Customer") {
    include "view/customer.php";
    exit();
  } else if(get_class($user) == "Model\Restaurant") {
    include "view/restaurant.php";
    exit();
  } else if (get_class($user) == "Model\DeliveryService") {
    include "view/deliveryService.php";
    exit();
  } else {
    echo "Error";
  }
}






?>