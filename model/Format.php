<?php

namespace Model;

trait Format {
  public function formatDate($date) {
    $date = strtotime($date);
    return date("d.m.y. h:i:sa", $date);
  }
  public static function formatNumber($num) {
    $num = number_format($num, 2, ",", ".");
    return $num;
  }
  public static function maxId(array $array) {
    $idArray = [];
    $maxId = 0;
    foreach($array as $item) {
      $idArray[] = $item->getId();
    }
    $maxId = max($idArray) + 1;
    return $maxId;
  }
  public static function idArray(array $array) {
    $idArray = [];
    foreach($array as $item) {
      $idArray[] = $item->getId();
    }   
    return $idArray;
  }

}

?>