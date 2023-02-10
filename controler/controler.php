<?php
namespace Controler;
use Model;
class Controler {
  use Model\Format;

  public static function counterForRemoveBtn($cartArray, $id) {
    if(!empty($cartArray)) {
      foreach($cartArray as $cartItem) {
        if($cartItem->item->getId() == $id) {
          return $cartItem->qty;
        }
      }
    } 
  }
  public static function disableRemoveItemBtn($id, $cartArray) {

    if(Controler::counterForRemoveBtn($cartArray, $id) < 1) {
      return "disabled";
    }
  }
}

?>