<?php
namespace Model;

class OrderItems {
  public Order $order;
  public Item $item;
  public $qty;
  public $total;

  public function __construct($order, $item, $qty)
  {
    $this->order = $order;
    $this->item = $item;
    $this->qty = $qty;
  }

  public static function getCustomerName($id, $array) {
    foreach($array as $order) {
      if($order->order->getId() == $id) {
        return $order->order->getCustomer()->getFirstName() . " " . $order->order->getCustomer()->getLastName();
      }
    }
  }

  public function getTotalForItem() {
    return $this->item->getPrice() * $this->qty;
  }

  public static function getGrandTotalForOrder($id, $array) {
    $totals = [];
    foreach ($array as $order) {
      if($order->order->getId() == $id) {
        $totals[] = $order->getTotalForItem();
      }
    }
    return array_sum($totals);
  }

  public static function getOrderRoute($id, $array) {
    foreach($array as $order) {
      if($order->order->getId() == $id) {
        return $order->order->getMap();
      }
    }
  }

  public static function getRestaurant($id, $array) {
    foreach($array as $order) {
      if($order->order->getId() == $id) {
        return $order->order->getRestaurant()->getName();
      }
    }

  }

}

?>