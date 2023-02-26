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
  <div class="cont d-flex position-relative">
    <div class="d-flex align-items-center">
      <h3 class="logo "><span class="text-warning">Food</span><span class="span2">D</span>elivery</h3>
    </div>
    <div class="nav_links d-flex align-items-center ms-auto">
      <ul class="d-flex mb-0 me-md-5">
        <li><a href="#">Home</a></li>
        <?php if(isset($restaurant)): ?>
          <li><a href="#items_section">Items</a></li>
        <?php endif ?>
        <li><a href="#orders_section">Orders</a></li>
        <li><a href="#">Contact</a></li>
        <?php if(isset($customer)): ?>
          <li id="cartIcon">
            <i class='bx bx-cart fs-2'></i>
            <span id="qtyInCart">
              <?= Model\ShoppingCart::getTotalQty($_SESSION['shoppingCart']) ?>
            </span>
            <!-- shopping cart -->
            <div id="cart" class="p-2 rounded-3 hidden1 bg-blur">
              <h3 class="text-center my-3 text-warning text-uppercase">Shopping Cart</h3>
              <table class="mx-auto">
                <thead>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                </thead>
                <tbody>
                  <?php
                    if(!empty($_SESSION['shoppingCart'])):
                      foreach($_SESSION['shoppingCart'] as $sc):
                  ?>
                  <tr>
                    <td>
                      <?= $sc->item->getName(); ?>
                    </td>
                    <td>
                      <?= $sc->formatNumber(intval($sc->item->getPrice())); ?>
                    </td>
                    <td>
                      <?= $sc->qty ?>
                    </td>
                    <td>
                      <?= $sc->formatNumber($sc->getTotal()) ?>
                    </td>
                  </tr>
                  <?php endforeach ?>
                </tbody>
                <?php else: ?>
                  <tr>
                    <td colspan="4">Empty Cart</td>
                  </tr>
                <?php endif ?>
                <tfoot>
                    <tr>
                      <td colspan=""></td>
                      <td colspan=""></td>
                      <td colspan="">Grand Total:</td>
                      <td id="grand_total"><?= Model\ShoppingCart::formatNumber(Model\ShoppingCart::getGrandTotal($_SESSION['shoppingCart'])) ?></td>
                    </tr>
                </tfoot>           
              </table><br>
              <div class="flex-row justify-content-center">
                <?php
                  function disableBtn() {
                    if (empty($_SESSION['shoppingCart'])) {
                      return "disabled";
                    }  
                  }
                ?>
                <form action="" method="post">
                  <input class="btn btn-outline-warning btn-sm" type="submit" value="Clear Cart" name="clear-cart" <?= disableBtn(); ?>>
                </form>
                <form action="" method="post">
                  <input class="btn btn-outline-success btn-sm" type="submit" value="Order" name="order" <?= disableBtn(); ?>>
                </form>
              </div>
            </div>
          </li>
        <?php endif ?>
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