<!-- header -->
<header id="header" class="">
  <div class="hero d-flex justify-content-center align-items-center ">
    <div class="hero_card d-flex align-items-center justify-content-center">
      <h3 >
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
  </div>
</header>
<!-- navbar -->
<nav id="navbar" class="myNavbar sticky-top">
  <div class="cont d-flex">
    <div class="d-flex align-items-center">
      <h3 class="logo "><span class="span1">Food</span><span class="span2">D</span>elivery</h3>
    </div>
    <div class="nav_links d-flex align-items-center ms-auto me-5">
      <ul class="d-flex mb-0 me-5">
        <li><a href="#">Home</a></li>
        <li><a href="#items_section">Items</a></li>
        <li><a href="#orders_section">Orders</a></li>
      </ul>
    </div>
    <div class="logout-box d-flex align-items-center">
      <form  action="" method="POST">
        <input class="btn btn-warning" type="submit" value="Logout" name="logout">
      </form>
    </div>
  </div>
</nav>

<?php

if(isset($_POST['logout'])) {
  unset($_SESSION['logged_user']);
  // session_unset();
  // session_destroy();
  header("Location: .");
}

?>