<?php


// if(isset($_POST['add_to_cart'])) {

//   $arrayOfIDs = Model\ShoppingCart::returnItemIDs($_SESSION['shoppingCart']);

//   if(in_array($_POST['itemId'], $arrayOfIDs)) {
//     foreach($_SESSION['shoppingCart'] as $i) {
//       if($_POST['itemId'] == $i->item->getId()) {
//         $i->qty++;
//         header("Refresh: 0");
//       }     
//     }  
//   } else {
//     foreach($_SESSION['items'] as $item) {
//       if($item->getId() == $_POST['itemId']) {
//         $_SESSION['shoppingCart'][] = new Model\ShoppingCart($item, 1);
//         header("Refresh: 0");
//       }
//     }   
//   }
// }

// if(isset($_POST['remove-from-cart'])) {

//   $arrayOfIDs = Model\ShoppingCart::returnItemIDs($_SESSION['shoppingCart']);

//   if(in_array($_POST['itemId'], $arrayOfIDs)) {
//     foreach($_SESSION['shoppingCart'] as $i) {
//       if($_POST['itemId'] == $i->item->getId()) {
//         if($i->qty > 1) {
//           $i->qty--;
//         } else {
//           $index = array_search($i, $_SESSION['shoppingCart']);
//           unset($_SESSION['shoppingCart'][$index]);
//           $_SESSION['shoppingCart'] = array_values($_SESSION['shoppingCart']);
//         }
//         header("Refresh: 0");  
//       }     
//     }  
//   } 
// }

if(isset($_POST['clear-cart'])) {
  unset($_SESSION['shoppingCart']);
  header("Refresh:0");
}

// if(isset($_POST['order'])) {

//   $autoIncrementID = Model\Order::autoIncrementID($_SESSION['orders']);

//   foreach($_SESSION['restaurants'] as $r) {
//     if($r->getId() == $_GET['rId']) {
//       $restaurant = $r;
//     }
//   }

//   $order = new Model\Order($autoIncrementID, $user, $restaurant, date("d.m.Y H:i:s"));

//   foreach($_SESSION['shoppingCart'] as $sc) {   
//     $_SESSION['orders'][] = new Model\OrderItems($order, $sc->item, $sc->qty);
//   }
//   unset($_SESSION['shoppingCart']);
//   header("Location: .");
// }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>Items</title>
</head>
<body>
  <div class="cont">
    <main class="min-vh-100">
    <div class="mt-4">
      <a href="./"><< Go Back</a>
    </div>
      <section id="items_section" class="mt-4">
        <h3 class="mb-2">Items:</h3>
        <div id="gridItems" class="gridItems justify-content-center gap-3">
          <?php
          $items = Model\Item::getAllItems($rId, $conn);
          if(!empty($items)) {
          foreach($items as $i):
          ?>
          <div class="card2 rounded-2 width-18 text-center bg-card">
            <p>Name: <?= $i['name'] ?></p>
            <p>Price: <?=  Model\Item::formatNumber($i['price']) ?></p>
            <p>Category: <?= $i['category'] ?></p>
            <!-- add/remove btns -->
            <div class="m-2 d-flex justify-content-center gap-3">
              <form action="" id="removeFromCartForm" name="removeFromCartForm">
                <input type="text" id="item_id" name="item_id" value="<?= $i['id'] ?>" hidden>
                <input type="text" name="restaurant_id" value="<?= $rId ?>" hidden>
                <input type="submit" name="remove_from_cart" class="btn btn-outline-danger btn-sm add-remove-btns" value="-">
              </form>
              <form action="" id="addToCartForm" name="addToCartForm">
                <input type="text" id="item_id" name="item_id" value="<?= $i['id'] ?>" hidden>
                <input type="text" name="restaurant_id" value="<?= $rId ?>" hidden>
                <input type="submit" name="add_to_cart" class="btn btn-outline-success btn-sm add-remove-btns" value="+">
              </form>
            </div>
          </div>
          <?php
            endforeach;
          } else echo "No Items!";
          ?>
        </div>
        <br><br>
        <!-- shopping cart -->
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
          <div class="flex-row">
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
      </section>
    </main>
  </div>
  <?php require_once "view/footer.php" ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
  <script src="js/main.js"></script>
</body>
</html>

<?php




?>