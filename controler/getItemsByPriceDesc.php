<?php

require_once "../db.php";
require_once "../model/item.php";

if(isset($_POST['restaurant_id'])) {
  $response = Model\Item::getDescByPrice($_POST['restaurant_id'], $conn);
  if($response) {
    echo json_encode($response);
  } else {
    echo $response . "Failed";
  }
}


?>