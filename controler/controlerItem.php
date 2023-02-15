<?php
require_once "../db.php";
require_once "../model/item.php";

// add item
if(isset($_POST['itemName']) && isset($_POST['itemPrice']) && isset($_POST['itemCategory']) && isset($_POST['restaurant_id'])) {

  if($_POST['itemName'] != "" && is_numeric($_POST['itemPrice']) && $_POST['itemCategory'] != "" && is_numeric($_POST['restaurant_id'])) {
    $name = $_POST['itemName'];
    $price = $_POST['itemPrice'];
    $category = $_POST['itemCategory'];
    $restaurant_id = $_POST['restaurant_id'];

    $response = Model\Item::addItem($name, $price, $category, $restaurant_id, $conn);
    if($response) {
      echo "Success";
    }
    else {
      echo $response;
      echo "Failed";
    }
  }
}

// delete item
if(isset($_POST['item_id']) && isset($_POST['restaurant_id'])) {
  $item_id = $_POST['item_id'];
  $restaurant_id = $_POST['restaurant_id'];
  if(is_numeric($item_id) && is_numeric($restaurant_id)) {
    $response = Model\Item::deleteItem($item_id, $restaurant_id, $conn);
    if($response) {
      echo "Success";
    }
    else {
      echo $response;
      echo "Failed";
    }
  }
}



?>