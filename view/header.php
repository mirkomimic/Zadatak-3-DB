<header id="header">
  <div >
    <h3>
      <?php
        switch ($user->type) {
          case 'Customer':
            echo $customer;
            break;
          case 'Delivery Service':
            echo $delivery_service;
            break;         
          default:
            echo $restaurant;
            break;
        }
      ?>
    </h3>
  </div>
  <div>
    <form action="" method="POST">
      <input type="submit" value="Logout" name="logout">
    </form>
  </div>
</header>

<?php

if(isset($_POST['logout'])) {
  unset($_SESSION['logged_user']);
  // session_unset();
  // session_destroy();
  header("Location: .");
}

?>