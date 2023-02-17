<?php

require_once "../db.php";
require_once "../model/item.php";

if(isset($_POST['item_id'])) {
  $response = Model\Item::find($_POST['item_id'], $conn);
  if($response) {
    echo json_encode($response);
  } else {
    echo $response . "Failed";
  }
}

?>