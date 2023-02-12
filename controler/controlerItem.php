<?php
namespace Controler;
use Model;

class Item {

  public static function getItemsByRestaurantID(Model\Restaurant $restaurant, $conn) {
    $id = $restaurant->getId();
    $query = "SELECT * FROM items WHERE restaurant_id=$id";
    $result = $conn->query($query);
    $array = [];
    if($result !== false && $result->num_rows > 0) {
      while($obj = $result->fetch_object()) {
        $item = new Model\Item($obj->id, $obj->name, $obj->price, $restaurant, $obj->category);
        $array[] = $item;
      }
      return $array;
    }
    return null;
  }

  public static function addItem($name, $price, $category, $restaurant_id, $conn) {
    $query = "INSERT INTO items (id, name, price, category, restaurant_id) 
              VALUES (null, '$name', $price, '$category', $restaurant_id)";
    $result = $conn->query($query);
    if($result === TRUE) echo "Item added";
    else echo "Item not added";
  }
}


?>