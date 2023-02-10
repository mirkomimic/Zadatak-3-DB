<?php

require_once "../db.php";

if(isset($_SESSION['logged_user'])) {
  header("Location: ../");
} else {
  if(isset($_POST['login'])) {
    if($_POST['email'] == "" || $_POST['password'] == "") {
      echo "Fill in all fields";
    } else {
      foreach($_SESSION['users'] as $user) {
        if($user->getEmail() == $_POST['email'] && $user->getPassword() == $_POST['password']) {
          $_SESSION['logged_user'] = $user;
          header("Location: ../");
          break;
        }
      }
      echo "Incorrect email or password";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>Login</title>
</head>
<body>
  <div id="login" class="">
    <div class="login-card">
      <div class="img-holder">
      </div>
      <div class="form-holder">
        <h1>Login</h1>
        <form action="" method="POST">
          <input type="text" name="email" id="email" placeholder="Email" required>
          <input type="text" name="password" id="passsword" placeholder="Password" required>

          <input type="submit" value="Login" name="login">
        </form>
      </div>
    </div>
  </div>
</body>
</html>