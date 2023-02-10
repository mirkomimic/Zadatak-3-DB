<?php
namespace Model;

class Order implements Map {
  use Format;
  private $id;
  private Customer $customer;
  private Restaurant $restaurant;
  public static $status = "waiting";
  private $date;

  public function __construct($id, Customer $customer, Restaurant $restaurant, $date)
  {
    $this->id = $id;
    $this->customer = $customer;
    $this->restaurant = $restaurant;
    $this->date = $date;
  }

  public function getGrandTotal($orderItems) {
    $totalPrice = 0;
    foreach($orderItems as $item) {
      $totalPrice += $item->getTotalPrice();
    }
    return $totalPrice;
  }

  public function countItems($orderItems) {
    $numOfItems = 0;
    foreach($orderItems as $item) {
      $numOfItems += $item->getQty();
    }
    // return count($orderItems);
    return $numOfItems;
  }

  public static function autoIncrementID($array) {
    $idArray = [];
    if(!empty($array)) {
      foreach($array as $i) {
        $idArray[] = $i->order->getId();
      }
      $idOrderArray = max($idArray) + 1;  
    } else {
      $idOrderArray = 1;
    }  
    return $idOrderArray;
  }

  public static function showDate($id, $array) {
    foreach($array as $order) {
      if($order->order->getId() == $id) {
        return $order->order->getDate();
      }
    }
  }
  
  public function getMap() {
    echo "Map: {$this->restaurant->getAddress()} to {$this->customer->getAddress()}";
  }

  public function getId() {
    return $this->id;
  }

  public function getCustomer() {
    return $this->customer;
  }
  public function getRestaurant() {
    return $this->restaurant;
  }

  public function getDate() {
    return $this->date;
  }

  public function __toString()
  {
    return "Order status: " . Order::$status . ".<br>Order id: $this->id.<br> Customer name: {$this->customer->getFirstName()} {$this->customer->getLastName()}.<br> Restaurant name: {$this->restaurant->getName()}.<br>Order date: {$this->getDate()}";
  }

}

?>