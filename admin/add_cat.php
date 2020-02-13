<?php
  define('ROOT', $_SERVER['DOCUMENT_ROOT']);
  require(ROOT.'/function/class.db.php');
  $db = new db();
  $skinaly[]= base64_encode('архитектура');
  $skinaly[].= base64_encode('еда');
  $skinaly[].= base64_encode('напитки');
  $skinaly[].= base64_encode('животные');
  $skinaly[].= base64_encode('кирпичи');
  $skinaly[].= base64_encode('кофе');
  $skinaly[].= base64_encode('лед');
  $skinaly[].= base64_encode('природа');
  $skinaly[].= base64_encode('разное');
  $skinaly[].= base64_encode('растения');
  for ($i=0; $i < count($skinaly); $i++) {
    $sql = "INSERT INTO `category` (catname,tagid) VALUES('".$skinaly[$i]."', 1)";
    echo $sql.'<br><hr>';
    $db->dbcon->query($sql);
  }
  echo '$skinaly= ok';
  $obchiy[]=base64_encode('вектор');
  $obchiy[].= base64_encode('архитектура');
  $obchiy[].= base64_encode('еда');
  $obchiy[].= base64_encode('напитки');
  $obchiy[].= base64_encode('животные');
  $obchiy[].= base64_encode('кирпичи');
  $obchiy[].= base64_encode('кофе');
  $obchiy[].= base64_encode('лед');
  $obchiy[].= base64_encode('природа');
  $obchiy[].= base64_encode('разное');
  $obchiy[].= base64_encode('растения');
  $obchiy[].= base64_encode('космос');
  $obchiy[].= base64_encode('ретро');
  $obchiy[].= base64_encode('детские');
  for ($i=0; $i < count($obchiy); $i++) {
    $sql = "INSERT INTO `category` (catname,tagid) VALUES('".$obchiy[$i]."', 5)";
    echo $sql.'<br><hr>';
    $db->dbcon->query($sql);
  }
  echo '$obchiy=ok';

  $fresky[]=base64_encode('архитектура');
  $fresky[].= base64_encode('природа');
  $fresky[].= base64_encode('вид с балкона');
  $fresky[].= base64_encode('арки');
  $fresky[].= base64_encode('абстракция');
  $fresky[].= base64_encode('ангелы');
  $fresky[].= base64_encode('детские');
  $fresky[].= base64_encode('карты');
  $fresky[].= base64_encode('морская');
  $fresky[].= base64_encode('люди');
  $fresky[].= base64_encode('растения');
  $fresky[].= base64_encode('Японская, Китайская тематика');
  for ($i=0; $i < count($fresky); $i++) {
    $sql = "INSERT INTO `category` (catname,tagid) VALUES('".$fresky[$i]."', 2)";
    echo $sql.'<br><hr>';
    $db->dbcon->query($sql);
  }
  echo '$fresky=ok';




?>
