<?php
namespace Controler;
use Model;
class Controler {
  use Model\Format;

  public static function login($email, $password, $conn) {
    $query = "SELECT id, firstname, lastname, address, email, password, type, null as name
              FROM users                 
              WHERE email='$email' AND password='$password'                 
              UNION ALL                 
              SELECT id, null as firstname, null as lastname, address, email, password, type, name                  
              FROM restaurants                  
              WHERE email='$email' AND password='$password'";      
    // return $conn->query($query);    
    $result = $conn->query($query);
    if($result->num_rows > 0) {
        return $result->fetch_object();
    } else {
        // echo "Wrong email or password";
        return null;
    }
  }


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