<?php

require_once "../db.php";
require_once "../model/item.php";

if(isset($_POST['restaurant_id'])) {
  $response = Model\Item::getItemsByName($_POST['restaurant_id'], $_POST['searchValue'], $conn);
  if($response) {
    echo json_encode($response);
  } else {
    echo $response . "Failed";
  }
}


?>