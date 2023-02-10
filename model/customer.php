<?php
namespace Model;

class Customer extends User {
  private $id;
  private $firstname;
  private $lastname;
  private $address;

  public function __construct($id, $firstname, $lastname, $address, $email, $password)
  {
    $this->id = $id;
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->address = $address;
    parent::__construct($email, $password);
  }


	public function getId() {
		return $this->id;
	}

	public function getFirstname() {
		return $this->firstname;
	}

	public function getLastname() {
		return $this->lastname;
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
    return "Customer: " . strtoupper($this->firstname) . " " . strtoupper($this->lastname);
  }
}

?>