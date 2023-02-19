<?php
namespace Model;

abstract class User {
  protected $email;
  protected $password;
  protected $type;

  public function __construct($email, $password, $type)
  {
    $this->email = $email;
    $this->setPassword($password);
    $this->type = $type;    
  }

  public function setPassword($password) {
    if(!preg_match('#[0-9]#', $password))
      throw new \Exception("Password must contain at least one number");
    $this->password = $password;
  }


}

?>