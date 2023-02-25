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
        if($i->qty > 1) {
          $i->qty--;
        } else {
          $index = array_search($i, $_SESSION['shoppingCart']);
          unset($_SESSION['shoppingCart'][$index]);
          $_SESSION['shoppingCart'] = array_values($_SESSION['shoppingCart']);
        }
      }
    }
  }
  echo "Success";

}

?>