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

  public static function getItemsByRestaurantID(Restaurant $restaurant, $conn) {
    $id = $restaurant->getId();
    $query = "SELECT * FROM items WHERE restaurant_id=$id";
    $result = $conn->query($query);
    $array = [];
    if($result !== false && $result->num_rows > 0) {
      while($obj = $result->fetch_object()) {
        $item = new Item($obj->id, $obj->name, $obj->price, $restaurant, $obj->category);
        $array[] = $item;
      }
      return $array;
    }
    return null;
  }

  public static function addItem($name, $price, $category, $restaurant_id, $conn) {
    $query = "INSERT INTO items (id, name, price, category, restaurant_id) 
              VALUES (null, '$name', $price, '$category', $restaurant_id)";
    return $conn->query($query);
  }

  public static function deleteItem($id, $restaurant_id, $conn) {
    $query = "DELETE FROM items WHERE id=$id AND restaurant_id=$restaurant_id";
    return $conn->query($query);
  }

  public static function find($id, $conn) {
    $query = "SELECT id, name, price, category FROM items WHERE id=$id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row;
  }

  public static function update($id, $name, $price, $category, $restaurant_id, $conn) {
    $query = "UPDATE items SET name='$name', price=$price, category='$category' WHERE  restaurant_id=$restaurant_id AND id=$id";
    return $conn->query($query);
  }

  public static function getDescByPrice($restaurant_id, $conn) {
    $query = "SELECT * FROM items WHERE restaurant_id=$restaurant_id ORDER BY price DESC";
    $result = $conn->query($query);
    
    $array= [];
    while($row = $result->fetch_assoc()) {
      $array[] = $row;
    }
    return $array;
  }

  public static function getAscByPrice($restaurant_id, $conn) {
    $query = "SELECT * FROM items WHERE restaurant_id=$restaurant_id ORDER BY price ASC";
    $result = $conn->query($query);
    
    $array= [];
    while($row = $result->fetch_assoc()) {
      $array[] = $row;
    }
    return $array;
  }

  public static function getItemsByName($restaurant_id, $searchValue, $conn) {
    $query = "SELECT * FROM items WHERE restaurant_id=$restaurant_id AND name LIKE '%$searchValue%'";
    $result = $conn->query($query);
    
    $array= [];
    while($row = $result->fetch_assoc()) {
      $array[] = $row;
    }
    return $array;
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