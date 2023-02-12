<?php
namespace Model;

abstract class User {
  protected $email;
  protected $password;
  protected $type;

  public function __construct($email, $password, $type)
  {
    $this->email = $email;
    $this->password = $password;
    $this->type = $type;    
  }

}

?>