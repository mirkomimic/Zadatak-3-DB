<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>Restaurant view</title>
</head>
<body>

  <div class="cont">
    <main class="min-vh-100">
      <!-- buttons and filters -->
      <section id="btns_and_filters" class="container pt-5">
        <!-- Buttons for modals -->
        <div class="row">      
          <div class="col">
            <div class="border border-success rounded-pill py-2 text-center max-w-300">
              <button type="button" class="btn btn-success btn-sm my-1" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</button>
              <button type="button" id="btn_edit_item" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editItemModal">Edit Item</button>
            </div>
          </div>
          <!-- text filter -->
          <div class="col d-flex align-items-center justify-content-center ">
            <div class="form-floating">
              <input type="text" name="itemSearch" class="form-control border-success border-2 bg-black text-light" id="search_input" placeholder="Search">
              <label for="search_input">Search</label>
            </div>
          </div>
          <!-- select filter -->
          <div id="price_sort" class="col my-auto">
          <select class="form-select form-select-lg border-success border-2 bg-black text-light ms-auto" id="select_filter" required>
            <option disabled hidden selected>Price &darr;&uarr;</option>
            <option name="priceDesc" value="priceDesc">Price &darr;</option>
            <option name="priceAsc" value="priceAsc">Price &uarr;</option>
          </select>
        </div>
        </div>
      </section>
      <!-- alert div -->
      <section id="alert_section" class="position-relative p-3">
        <div class="alert alert-success col-md-3 m-auto position-absolute top-50 start-50 translate-middle" id="alert" role="alert">
          <strong>Alert</strong>
        </div>
      </section>
      <!-- items section -->
      <section id="items_section" class="d-flex flex-column">
        <h3 class="my-3 text-warning text-uppercase text-center">Your items</h3>
        
        <div id="gridItems" class="gridItems justify-content-center gap-3 mb-4">
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
        <!-- pagination -->
        <nav id="pagination" class="mt-auto" aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </section>
    
      
      <!-- Orders -->
      <section id="orders_section">
        <h3 class="text-warning text-uppercase text-center my-3">Orders for you</h3>
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
      </section>

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
                  <input type="text" name="itemName" class="form-control text-light" placeholder="Item Name" id="floatingInputName" required>
                  <label class="text-light" for="floatingInputName">Name</label>
                </div>
                <div class="mb-3 form-floating">
                  <input type="text" name="itemPrice" class="form-control text-light" id="floatingInputPrice" placeholder="Price" required>
                  <label class="text-light" for="floatingInputPrice">Price</label>
                </div>
                <div class="mb-3 ">
                  <select class="form-select form-select-lg text-light" name="itemCategory" required>
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
                  <input type="text" name="item_id" class="form-control " placeholder="Item ID" id="floatingInputId2" required hidden>
                </div>
                <div class="mb-3 form-floating">
                  <input type="text" name="itemName" class="form-control text-light" placeholder="Item Name" id="floatingInputName2" required>
                  <label class="text-light" for="floatingInputName2">Name</label>
                </div>
                <div class="mb-3 form-floating">
                  <input type="text" name="itemPrice" class="form-control text-light" id="floatingInputPrice2" placeholder="Price" required>
                  <label class="text-light" for="floatingInputPrice2">Price</label>
                </div>
                <div class="mb-3 ">
                  <select class="form-select form-select-lg text-light" name="itemCategory" required>
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
    </main>
  </div>
  <?php include "view/footer.php"; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
  <script src="js/main.js"></script>
  <!-- <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script> -->
</body>
</html>