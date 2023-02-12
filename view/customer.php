<?php
  // include "view/header.php";


// if(isset($_GET['rId'])) {
//   $rId = $_GET['rId'];
//   include "view/items.php";
//   exit();
// } else {
//   unset($_SESSION['shoppingCart']);
// }

// if(isset($_POST['reset-orders'])) {
//   unset($_SESSION['orders']);
//   header("Refresh:0");
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Customer view</title>
</head>
<body>
  <div class="cont">
    <h3>Restaurants:</h3>
    <?php
      foreach($_SESSION['restaurants'] as $r):
    ?>
    <p class="margin-bottom"><a href="?rId=<?= $r->getId(); ?>"><?= $r->getName(); ?></a></p>
    <?php
      endforeach;
    ?>
    <hr>
    <!-- Orders -->
    <h3>Your Orders: </h3>
    <form action="" method="post">
      <input type="submit" value="reset orders" name="reset-orders">
    </form>
    <?php 
      if(!empty($_SESSION['orders'])) {
        $idArray = [];
        foreach($_SESSION['orders'] as $i) {
          if($i->order->getCustomer() === $user)
            $idArray[] = $i->order->getId();
        }
        $uniqueIdCartArray = array_unique($idArray);  
      }
    ?>

    <br>
    <div class="flex flex-column flex-reverse">
      <?php 
        if(!empty($uniqueIdCartArray)) {
          foreach($uniqueIdCartArray as $id) :      
      ?>
        <div class="card p-1">
          <div class="flex justify-content-between">
            <p>Order ID: <?= $id ?></p> | 
            <p>Order Date: <?= Model\Order::showDate($id, $_SESSION['orders']) ?></p> | 
            <p>Customer: <?= Model\OrderItems::getCustomerName($id, $_SESSION['orders']) ?></p>
          </div>
          <br>
          <div>
            <table class="margin-auto">
              <thead>
                <tr>
                  <th>Item Name</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
            <?php 
              foreach($_SESSION['orders'] as $orderItem) : 
                if($orderItem->order->getId() == $id) :
            ?>
                <tr>
                  <td><?= $orderItem->item->getName() ?></td>
                  <td><?= $orderItem->qty ?></td>
                  <td><?= Controler\Controler::formatNumber($orderItem->item->getPrice()) ?></td>
                  <td><?= Controler\Controler::formatNumber($orderItem->getTotalForItem()) ?></td>
                </tr>             
                <?php endif; ?>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td></td>
                  <td></td>
                  <td>Grand Total</td>
                  <td><?= Controler\Controler::formatNumber(Model\OrderItems::getGrandTotalForOrder($id, $_SESSION['orders'])) ?></td>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="flex justify-content-between margin-top">
            <p class=""><?= Model\OrderItems::getOrderRoute($id, $_SESSION['orders']) ?></p>
            <p>|</p>
            <p class="">Order status: <?= Model\Order::$status ?></p>
            <p>|</p>
            <p class="">Restaurant: <?= Model\OrderItems::getRestaurant($id, $_SESSION['orders'])  ?></p>
          </div>
        </div>
        <?php endforeach ?>
        <?php } else { ?>
          <p>No orders!</p>
        <?php } ?>
    </div>

  </div>
</body>
</html>