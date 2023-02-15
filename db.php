<?php

require_once __DIR__ . "/model/Format.php";
require_once __DIR__ . "/model/user.php";
require_once __DIR__ . "/model/customer.php";
require_once __DIR__ . "/model/restaurant.php";
require_once __DIR__ . "/model/deliveryService.php";
require_once __DIR__ . "/model/item.php";
require_once __DIR__ . "/model/iMap.php";
require_once __DIR__ . "/model/order.php";
require_once __DIR__ . "/model/shoppingCart.php";
require_once __DIR__ . "/model/OrderItems.php";
// require_once __DIR__ . "/controler/controler.php";
// require_once __DIR__ . "/controler/controlerItem.php";

session_start();

if(!isset($_SESSION['shoppingCart'])) {
  $_SESSION['shoppingCart'] = [];
}

class DB {
  private static $conn;

  public static function connectDB() {
    // singleton pattern
    if (self::$conn == null)
      self::$conn = new mysqli('localhost', 'root', '', 'food_delivery');
    return self::$conn;
  }
}

$conn = DB::connectDB();


// $customer1 = new Model\Customer(1, "Petar", "Petrovic", "Tosin Bunar", "petar@gmail.com", "petar123");
// $customer2 = new Model\Customer(2, "Marko", "Markovic", "Sarajevska", "marko@gmail.com", "marko123");

// $mac = new Model\Restaurant(1, "McDonalds", "Deligradska", "Mc@gmail.com", "mac123");
// $savcic = new Model\Restaurant(2, "Savcic", "Kralja Milutina", "savcic@email.com", "savcic123");


// $delivery = new Model\DeliveryService(1, "John", "Doe", "john@gmail.com", "john123");


// $item1 = new Model\Item(1, "Big Mac", 500, $mac);
// $item2 = new Model\Item(2, "Cheeseburger", 450, $mac);
// $item3 = new Model\Item(3, "Cevapi", 470, $savcic);
// $item4 = new Model\Item(4, "Milkshake", 300, $mac);


// $usersArray = [$mac, $savcic, $customer1, $customer2, $delivery];

// $restaurantArray = [$mac, $savcic];

// $itemsArray = [$item1, $item2, $item3, $item4];



// if(!isset($_SESSION['users'])) {
//   $_SESSION['users'] = $usersArray;
// }

// if(!isset($_SESSION['orders'])) {
//   $_SESSION['orders'] = [];
// }
// if(!isset($_SESSION['items'])) {
//   $_SESSION['items'] = $itemsArray;
// }
// if(!isset($_SESSION['restaurants'])) {
//   $_SESSION['restaurants'] = $restaurantArray;
// }



?>