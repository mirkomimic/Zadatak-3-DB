<?php

require_once "../db.php";

if(!isset($array)) {
  $array = [];
}

foreach($_SESSION['shoppingCart'] as $i ) {
  // $array["id"] = $i->item->getId();
  // $array["name"] = $i->item->getName();
  // $array["price"] = $i->item->getPrice();
  // $array["qty"] = $i->qty;

  $array[] = array(
    "id" => $i->item->getId(),
    "name" => $i->item->getName(),
    "price" => $i->item->getPrice(),
    "qty" => $i->qty,
  );

} 
echo json_encode($array);
// return $array;
// echo json_encode($_SESSION['shoppingCart']);

?>