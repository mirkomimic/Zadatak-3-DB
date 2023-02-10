<?php
namespace Model;

abstract class User {
  protected $email;
  protected $password;

  public function __construct($email, $password)
  {
    $this->email = $email;
    $this->password = $password;
  }

}

?>