<?php
namespace Model;


class Restaurant extends User {
  use Format;
  private $id;
  private $name;
  private $address;

  public function __construct($id, $name, $address, $email, $password)
  {
    $this->id = $id;
    $this->name = $name;
    $this->address = $address;
    parent::__construct($email, $password);
  }

  public function viewItems(Item ...$array) {
    foreach($array as $item) {
      if($item->getRestaurant()->getId() == $this->id) {
        echo $item;
      }
    }
  }


	public function getId() {
		return $this->id;
	}
	public function getName() {
		return $this->name;
	}
	public function getAddress() {
		return $this->address;
	}
  public function getEmail() {
    return $this->email;
  }
  public function getPassword() {
    return $this->password;
  }

  public function __toString()
  {
    return "Restaurant: $this->name<br>";
  }

}

?>