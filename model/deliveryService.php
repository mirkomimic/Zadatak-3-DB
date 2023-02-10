<?php
namespace Model;

class DeliveryService extends User {
  private $id;
  private $firstname;
  private $lastname;

  public function __construct($id, $firstname, $lastname, $email, $password) 
  {
    $this->id = $id;
    $this->firstname = $firstname;
    $this->lastname = $lastname;
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
	public function getPassword() {
		return $this->password;
	}
	public function getEmail() {
		return $this->email;
	}

	public function __toString()
	{
		return "Delivery service: " . strtoupper($this->getFirstname()) . " " . strtoupper($this->getLastname());
	}
}

?>