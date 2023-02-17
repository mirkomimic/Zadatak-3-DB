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

<div class="cont h-100 margin-top-5">
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-success btn-sm me-3" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</button>
  <button type="button" id="btn_edit_item" class="btn btn-success btn-sm me-3" data-bs-toggle="modal" data-bs-target="#editItemModal">Edit Item</button>

  <!-- filters -->
  <div class="d-flex align-content-center mb-3">
    <div class="col-md-3 me-auto"></div>
    <div class=" col-md-3  ">
      <div class="mb-3 form-floating ">
        <input type="text" name="itemPrice" class="form-control" id="search_input" placeholder="Search">
        <label for="search_input">Search</label>
      </div>
    </div>
    <div class="col-md-3 ms-auto">
      <select class="form-select form-select-lg" id="select_filter" required>
        <option disabled hidden selected>Select filter</option>
        <option name="priceDesc" value="priceDesc">Price &darr;</option>
        <option name="priceAsc" value="priceAsc">Price &uarr;</option>
      </select>
    </div>
  </div>

  <h3 class="mb-2">Your items:</h3>
  <div id="gridItems" class="gridItems justify-content-center gap-3">
    <?php
      $items = Model\Item::getItemsByRestaurantID($restaurant, $conn);
      // print_r($item);
      if(!empty($items)) {
      foreach($items as $i):
    ?>
    <div class="card width-18 text-center bg-card">
      <p>Name: <?= $i->getName() ?></p>
      <p>Price: <?= $i->getPrice() ?></p>
      <p>Category: <?= $i->getCategory() ?></p>
      <div class="m-2">
        <form action="" class="deleteItemForm" name="deleteItemForm">
          <input type="text" id="item_id" name="item_id" value="<?= $i->getId() ?>" hidden>
          <input type="text" name="restaurant_id" value="<?= $restaurant->getId() ?>" hidden>
          <input type="submit" class="btn btn-outline-danger btn-sm" value="Delete">
        </form>
      </div>
    </div>
    <?php
      endforeach;
    } else echo "No Items!";
    ?>
  </div>
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

  <!-- Add Item Modal -->
  <div class="modal fade bg-blur" id="addItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-modal">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- add-item form -->
          <form action="" method="post" id="addItemForm" name="addItemForm">
            <div class="mb-3 form-floating">
              <input type="text" name="itemName" class="form-control" placeholder="Item Name" id="floatingInputName" required>
              <label for="floatingInputName">Name</label>
            </div>
            <div class="mb-3 form-floating">
              <input type="text" name="itemPrice" class="form-control" id="floatingInputPrice" placeholder="Price" required>
              <label for="floatingInputPrice">Price</label>
            </div>
            <div class="mb-3 ">
              <select class="form-select form-select-lg" name="itemCategory" required>
                <option selected disabled hidden>Select category</option>
                <option value="Food">Food</option>
                <option value="Drink">Drink</option>
              </select>
            </div>
            <div class="mb-3 form-floating">
              <input type="text" name="restaurant_id" class="form-control" id="restaurant_id" placeholder="Price" value="<?= $restaurant->getId() ?>" required hidden>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="addItemForm" name="add_item">Add Item</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Edit Item Modal -->
  <div class="modal fade bg-blur" id="editItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-modal">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- edit-item form -->
          <form action="" method="post" id="editItemForm" name="editItemForm">
            <div class="mb-3 form-floating">
              <input type="text" name="item_id" class="form-control" placeholder="Item ID" id="floatingInputId2" required hidden>
            </div>
            <div class="mb-3 form-floating">
              <input type="text" name="itemName" class="form-control" placeholder="Item Name" id="floatingInputName2" required>
              <label for="floatingInputName2">Name</label>
            </div>
            <div class="mb-3 form-floating">
              <input type="text" name="itemPrice" class="form-control" id="floatingInputPrice2" placeholder="Price" required>
              <label for="floatingInputPrice2">Price</label>
            </div>
            <div class="mb-3 ">
              <select class="form-select form-select-lg" name="itemCategory" required>
                <option selected disabled hidden>Select category</option>
                <option value="Food">Food</option>
                <option value="Drink">Drink</option>
              </select>
            </div>
            <div class="mb-3 form-floating">
              <input type="text" name="restaurant_id" class="form-control" id="floatingInputRestaurantId" placeholder="Price" value="<?= $restaurant->getId() ?>" required hidden>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="editItemForm" name="edit_item">Edit Item</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "view/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
</body>
</html>