<?php
if ((isset($_POST['cart']))&(isset($_POST['id']))){
  $id=$_POST['id'];
  if ($_POST['cart']=='add'){
    if (isset($_COOKIE['cart'])){
      $cart = $_COOKIE['cart'];
      $value = $cart.$id.'::';
      setcookie("cart", $value , time()+3600,'/');
      // echo "ADD more";
    }else{
      $value = $id.'::';
      setcookie("cart", $value , time()+3600,'/');
      // echo "ADD first";
    }
  }
}else{
header('HTTP/1.0 404 Not Found', true, 404);
die();
}
