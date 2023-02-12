<?php

if(isset($_POST['add-item'])) {
  if($_POST['itemName'] != "" && is_numeric($_POST['itemPrice']) && $_POST['itemCategory'] != "") {
    $name = $_POST['itemName'];
    $price = $_POST['itemPrice'];
    $category = $_POST['itemCategory'];

    Controler\Item::addItem($name, $price, $category, 1, $conn);
    header("Location: .");
  }
  echo "Error. Check fields";

}

?>