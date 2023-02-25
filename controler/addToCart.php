<?php

require_once "../db.php";
require_once "../model/item.php";
require_once "../model/restaurant.php";
require_once "../model/shoppingCart.php";

if(isset($_POST['item_id']) && isset($_POST['restaurant_id'])) {
  $item_id = $_POST['item_id'];
  $restaurant_id = $_POST['restaurant_id'];

  $arrayOfIDs = Model\ShoppingCart::returnItemIDs($_SESSION['shoppingCart']);

  if(in_array($item_id, $arrayOfIDs)) {
    foreach($_SESSION['shoppingCart'] as $i) {
      if($item_id == $i->item->getId()) {
        $i->qty++;
      }     
    }  
  } else {
    $itemObj = Model\Item::getItem($item_id, $conn);
    $restaurantObj = Model\Restaurant::getRestaurantById($restaurant_id, $conn);
  
    $restaurant = new Model\Restaurant($restaurantObj->id, $restaurantObj->name, $restaurantObj->address, $restaurantObj->email, $restaurantObj->password, $restaurantObj->type);
  
    $item = new Model\Item($itemObj->id, $itemObj->name, $itemObj->price, $restaurant, $itemObj->category);
  
    $shoppingCart = new Model\ShoppingCart($item, 1);
  
    $_SESSION['shoppingCart'][] = $shoppingCart;  
  }
  echo "Success";


}

?>