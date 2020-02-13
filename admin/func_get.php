<?php
define('ROOT', $_SERVER['DOCUMENT_ROOT']);

if (isset($_GET['action'])){
  if ($_GET['action']=='del'){
    // echo 'удаляем';
    $id = $_GET['id'];
    $href = base64_decode($_GET['href']);
    require ROOT.'/function/class.db.php';
    // echo '$id= '.$id.' $href='.$href;
    unlink(ROOT.'/uploads/250/'.$href);
    unlink(ROOT.'/uploads/1600/'.$href);
    $con= new db();
    $sql = 'DELETE FROM `image` WHERE id='.$id.';';
    // echo $sql;
    if ($result = $con->dbcon->query($sql)){
      // echo 'Удалено';
      header('Location: '. $_SERVER['HTTP_REFERER']);
    }else{
      echo 'ERROR: Что то не так';
    }
  }elseif ($_GET['action']=='edit') {
    require 'edit_image.php';
  }
}elseif(isset($_GET['del'])){
  require ROOT.'/function/class.db.php';
  $con= new db();
  if($_GET['del']=='tag'){
    $tags='';
    $id = $_GET['tagid'];
    $sql = 'DELETE FROM `tags` WHERE id='.$id.';';
    $sql2 = 'SELECT `tag_id`,`id` FROM `image` WHERE tag_id LIKE "%'.$id.'::%"';
    if ($result2 = $con->dbcon->query($sql2)){
      // print_r($result2);
      while ($row2 = $result2->fetch_assoc()){
        // print_r($row2);
        $tag_id[]=explode("::",$row2['tag_id']);
        // print_r($tag_id[0]);
        foreach ($tag_id[0] as $key => $value) {
          // print_r( $value );
          if($value == null ){
            // echo $id.'1';
            unset($tag_id[0][$key]);
          }elseif($value==$id){
            // echo $id.'2';
            unset($tag_id[0][$key]);
          }
        }
        // print_r($tag_id[0]);
        foreach ($tag_id[0] as $key => $value) {
          $tags.= $value."::";
        }
        // echo $tags;
        $sql3='UPDATE `image` SET tag_id ="'.$tags.'" WHERE id = "'.$row2['id'].'" ;';
        if ($result3 = $con->dbcon->query($sql3)){
          echo 'OK';
        }else{
          echo "ERROR Не смог обновить данные по картинкам";
        }
      }

    }else{
      echo "ERROR Не смог загрузить данные из таблицы картинок";
    }
    if ($result = $con->dbcon->query($sql)){
      header('Location: /admin/?page=tags');
    }else{
      echo "ERROR Не смог обновить таблицу тегов";
    }
  }
  if($_GET['del']=='user'){
    $user_id = $_GET['userid'];
    $sql = 'DELETE FROM `user` WHERE id = '.$user_id.';';
    if ($result=$con->dbcon->query($sql)){
      header('Location: /admin/?page=users');
    }else{
      echo "ERROR Не удалось удалить пользователя";
    }
  }
  if($_GET['del']=='orders'){
    $order_id = $_GET['order_id'];
    $sql = 'DELETE FROM `orders` WHERE id = '.$order_id.';';
    if ($result=$con->dbcon->query($sql)){
      header('Location: /admin/?page=orders');
    }else{
      echo "ERROR Не удалось удалить заявку";
    }
  }
}else{
  header('HTTP/1.0 404 Not Found', true, 404);
  die();
}
?>
