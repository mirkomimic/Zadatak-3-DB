<?php


if(isset($_POST['add_to_cart'])) {

  $arrayOfIDs = Model\ShoppingCart::returnItemIDs($_SESSION['shoppingCart']);

  if(in_array($_POST['itemId'], $arrayOfIDs)) {
    foreach($_SESSION['shoppingCart'] as $i) {
      if($_POST['itemId'] == $i->item->getId()) {
        $i->qty++;
        header("Refresh: 0");
      }     
    }  
  } else {
    foreach($_SESSION['items'] as $item) {
      if($item->getId() == $_POST['itemId']) {
        $_SESSION['shoppingCart'][] = new Model\ShoppingCart($item, 1);
        header("Refresh: 0");
      }
    }   
  }
}

if(isset($_POST['remove-from-cart'])) {

  $arrayOfIDs = Model\ShoppingCart::returnItemIDs($_SESSION['shoppingCart']);

  if(in_array($_POST['itemId'], $arrayOfIDs)) {
    foreach($_SESSION['shoppingCart'] as $i) {
      if($_POST['itemId'] == $i->item->getId()) {
        if($i->qty > 1) {
          $i->qty--;
        } else {
          $index = array_search($i, $_SESSION['shoppingCart']);
          unset($_SESSION['shoppingCart'][$index]);
          $_SESSION['shoppingCart'] = array_values($_SESSION['shoppingCart']);
        }
        header("Refresh: 0");  
      }     
    }  
  } 
}

if(isset($_POST['clear-cart'])) {
  unset($_SESSION['shoppingCart']);
  // header("Refresh:0");
}

if(isset($_POST['order'])) {

  $autoIncrementID = Model\Order::autoIncrementID($_SESSION['orders']);

  foreach($_SESSION['restaurants'] as $r) {
    if($r->getId() == $_GET['rId']) {
      $restaurant = $r;
    }
  }

  $order = new Model\Order($autoIncrementID, $user, $restaurant, date("d.m.Y H:i:s"));

  foreach($_SESSION['shoppingCart'] as $sc) {   
    $_SESSION['orders'][] = new Model\OrderItems($order, $sc->item, $sc->qty);
  }
  unset($_SESSION['shoppingCart']);
  header("Location: .");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Items</title>
</head>
<body>
  <div id="items" class="cont">
    <h3>Items:</h3>
    <?php
      foreach($_SESSION['items'] as $i) :
        if($i->getRestaurant()->getId() == $rId) :
    ?>
    <p><?= $i ?></p>
    <!-- add/remove buttons -->
    <div class="flex-row">
      <form action="" method="post">
        <input type="hidden" name="itemId" value="<?= $i->getId() ?>">
        <input type="submit" value="Add To Cart" name="add_to_cart">
      </form>
      <form action="" method="post">
        <input type="hidden" name="itemId" value="<?= $i->getId() ?>">
        <input type="submit" value="Remove From Cart <?= Controler\Controler::counterForRemoveBtn(isset($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : null, $i->getId()) ?>" name="remove-from-cart" <?= Controler\Controler::disableRemoveItemBtn($i->getId(), isset($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : null) ?>>
      </form>
    </div>
    <?php
        endif;
      endforeach;
    ?>
    <br><br>
    <a href="./"><< Go Back</a>

    <div id="cart">
      <h3>Shopping Cart:</h3>
      <table>
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
              <?= $sc->formatNumber($sc->item->getPrice()); ?>
            </td>
            <td>
              <?= $sc->qty ?>
            </td>
            <td>
              <?= $sc->formatNumber($sc->getTotal()) ?>
            </td>
          </tr>
          <?php endforeach ?>
          <tfoot>
            <tr>
              <td colspan=""></td>
              <td colspan=""></td>
              <td colspan="">Grand Total:</td>
              <td><?= Model\ShoppingCart::formatNumber(Model\ShoppingCart::getGrandTotal($_SESSION['shoppingCart'])) ?></td>
            </tr>
          <?php else: ?>
            <tr>
              <td colspan="4">Empty Cart</td>
            </tr>
          <?php endif ?>
          </tfoot>
        </tbody>
      </table><br>
      <div class="flex-row">
        <?php
          function disableBtn() {
            if (empty($_SESSION['shoppingCart'])) {
              return "disabled";
            }  
          }
        ?>
        <form action="" method="post">
          <input type="submit" value="Clear Cart" name="clear-cart" <?= disableBtn(); ?>>
        </form>
        <form action="" method="post">
          <input type="submit" value="Order" name="order" <?= disableBtn(); ?>>
        </form>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
  <script src="JS/main.js"></script>
</body>
</html>

<?php




?>