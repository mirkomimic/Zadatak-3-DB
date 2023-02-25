<?php
namespace Model;


class ShoppingCart {
  use Format;
  public Item $item;
  public $qty;

  public function __construct($item, $qty) {
    $this->item = $item;
    $this->qty = $qty;
  }

  // private function getItem() {
  //   return $this->item;
  // }

  public static function returnItemIDs($array) {
    $arrayOfIDs = [];
    foreach($array as $a) {
      $arrayOfIDs[] = $a->item->getId();
    }
    return $arrayOfIDs;
  }

  public static function getGrandTotal($array) {
    $grandTotal = 0;
    foreach($array as $sc) {
      $grandTotal += $sc->getTotal();
    }
    return $grandTotal;
  }

  public static function getTotalQty($array) {
    $totalQty = 0;
    foreach($array as $sc) {
      $totalQty += $sc->qty;
    }
    return $totalQty;
  }

  public function getTotal() {
    return intval($this->item->getPrice()) * $this->qty;
  }



}

?>