<?php

require_once "../db.php";

if(isset($_SESSION['logged_user'])) {
  header("Location: ../");
} else {
  if(isset($_POST['login'])) {
    if($_POST['email'] == "" || $_POST['password'] == "") {
      echo "Fill in all fields";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // $query = ("SELECT * FROM restaurants
        //           WHERE email='$email'");
        // $query = ("SELECT * FROM users, restaurants 
        //           WHERE users.email='$email'
        //           AND users.password='$password'
        //           OR restaurants.email = '$email'
        //           AND restaurants.password='$password'");

        $query = ("SELECT * FROM users 
                  WHERE email='$email'
                  AND password='$password'");
        $result = $conn->query($query);
        if($result->num_rows == 1) {
          
          $_SESSION['logged_user'] = $result->fetch_object();
          header("Location: ../");
        } else {
          $query2 = ("SELECT * FROM restaurants 
                      WHERE email='$email'
                      AND password='$password'");
          $result2 = $conn->query($query2);
  
          if($result2->num_rows == 1) {
            $_SESSION['logged_user'] = $result2->fetch_object();
            header("Location: ../");    
          }
        }

      }
      echo "Incorrect email or password";
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