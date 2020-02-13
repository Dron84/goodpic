<?php
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
require(ROOT.'/function/class.db.php');
$con = new db();
if (isset($_POST['edit_image'])){
  $old_name = $_POST['old_name'];
  $name = $_POST['name'];
  $folder = $_POST['category'];
  $comment = $_POST['comment'];
  $size = $_POST['size'];
  $id = $_POST['id'];
  $price = $_POST['price'];
  $tag_id = '';
  if (isset($_POST['tags'])){
  	$tags = array();
  	$tags_str = $_POST['tags'];
  	$tags_array= explode(' , ', $tags_str);
  	foreach ($tags_array as $key => $value) {
  		$tags[].= base64_encode(trim($value));
  	}
  	$con = new db();
  	foreach ($tags as $key => $value) {
  		$result = $con->dbcon->query('SELECT * FROM `tags` WHERE `tagname` = "'.$value.'"');
  		if (!$result->num_rows>0){
  			$con->insert('tags','tagname',$value);
  			$result = $con->dbcon->query('SELECT * FROM `tags` WHERE `tagname` = "'.$value.'"');
  		}
  		$row=$result->fetch_assoc();
  		$tag_id.= $row['id']."::";
  	}
  }
  $sql = "UPDATE `image` SET folder = '".$folder."', size = '".$size."', tag_id = '".$tag_id."', href = '".$name."', px250 = true, px1600 = true, price = '".$price."' WHERE id=".$id.";";
  // echo $sql;
  if ($result = $con->dbcon->query($sql)){
    // if ($old_name!=$name){
    //   rename("/uploads/250/".$old_name , "/uploads/250/".$name);
    //   rename("/uploads/1600/".$old_name , "/uploads/1600/".$name);
    // }
    echo "OK";
  }else{
    echo "Что то не так с БД";
  }
}
?>
