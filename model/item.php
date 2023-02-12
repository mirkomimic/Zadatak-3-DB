<?php
namespace Model;

class Item {
  use Format;
  private $id;
  private $name;
  private $price;
  private Restaurant $restaurant;
  private $category;

  public function __construct($id, $name, $price, Restaurant $restaurant, $category)
  {
    $this->id = $id;
    $this->name = $name;
    // $this->price = $price;
    $this->setPrice($price);
    $this->restaurant = $restaurant;
    $this->category = $category;
  }

  // potrebno za array_column sa objektima
  // public function __get($i) {
  //   return $this->$i;
  // }
  // public function __isset($i) {
  //   return $this->$i;
  // }

  public function getId() {
    return $this->id;
  }
	public function getRestaurant(): Restaurant {
		return $this->restaurant;
	}
  public function getName() {
    return $this->name;
  }
  public function getPrice() {
    return $this->price;
  }
  public function getCategory() {
    return $this->category;
  }

  public function setPrice($price) {
    $this->price = Format::formatNumber(intval($price));

    return $this;
  }



  public function __toString()
  {
    return "Item id: $this->id. <br> Item name: $this->name<br> Price: {$this->formatNumber($this->getPrice())} <br>Restaurant: {$this->restaurant->getName()}<br><br>";
  }

}

?>