<header id="header" class="sticky-top">
  <div class="cont navbar">
    <h3 class="logo">Food Delivery</h3>
    <div class="title">
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
    <div class="logout-box">
      <form  action="" method="POST">
        <input class="btn btn-warning" type="submit" value="Logout" name="logout">
      </form>
    </div>
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