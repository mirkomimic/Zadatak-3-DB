<?php

// if(isset($_POST['add-item'])) {
//   $maxId = Model\Restaurant::maxId($itemsArray);
//   $_SESSION['items'][] = new Model\Item($maxId, $_POST['itemName'], $_POST['itemPrice'], $user);
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
  <title>Restaurant view</title>
</head>
<body>

<div class="cont">
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</button>

  <h3>Your items:</h3>
  <?php
    // $user->viewItems(...$_SESSION['items']);
  ?>
  <hr>
  <!-- Orders -->
  <h3>Orders for you:</h3>
  <form action="" method="post">
    <input type="submit" value="reset orders" name="reset-orders">
  </form>
  <?php 
    // if(!empty($_SESSION['orders'])) {
    //   $idArray = [];
    //   foreach($_SESSION['orders'] as $i) {
    //     if($i->order->getRestaurant() === $user)
    //       $idArray[] = $i->order->getId();
    //   }
    //   $uniqueIdCartArray = array_unique($idArray);  
    // }
  ?>

  <br>
  <!-- <div class="flex flex-column flex-reverse"> -->
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

  <!-- Modal -->
  <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- add-item form -->
          <form action="" method="post" id="addItemForm">
            <div class="mb-3 form-floating">
              <input type="text" name="itemName" class="form-control" placeholder="Item Name" id="floatingInput" required>
              <label for="floatingInput">Name</label>
            </div>
            <div class="mb-3 form-floating">
              <input type="text" name="itemPrice" class="form-control" id="floatingInputPrice" placeholder="Price" required>
              <label for="floatingInputPrice">Price</label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="addItemForm" name="add-item">Add Item</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>