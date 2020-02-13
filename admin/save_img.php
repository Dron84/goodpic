<?php
error_reporting( E_ALL );
ini_set('display_errors', '1');

define('ROOT',$_SERVER['DOCUMENT_ROOT']);
require(ROOT.'/function/class.db.php');
require(ROOT.'/function/classSimpleImage.php');
// require(ROOT.'/function/classSSH.php');

// variables
global $tag_id,$comment,$catagory,$size, $href, $new_name ;

//get name
function href(){
	$href = $_FILES["image"]["name"];
	if (isset($_POST['newname'])){
		$new_name = $_POST['newname'];
		if (strlen($new_name)>0){
			$href=basename($new_name.'.jpg');
		}
	}
	return $href;
}

// get a pictures size
if ( (empty($_POST['width'])) or (empty($_POST['height'])) ){
	$tmp_name = $_FILES["image"]["tmp_name"];
	// print_r($tmp_name);
	$image = new SimpleImage();
	$image->load($tmp_name);
	$width = $image->getWidth();
	$height = $image->getHeight();
	$size = $width."x".$height;
}elseif ( (isset($_POST['width'])) or (isset($_POST['height'])) ){
	$width = $_POST['width'];
	$height = $_POST['height'];
	$size = $width."x".$height;
}
// get a comment
if (isset($_POST['comment'])){
	$comment = base64_encode($_POST['comment']);
}
// get a catagory
if (isset($_POST['category'])){
	$catagory = $_POST['category'];
	setcookie('category',$catagory, time()+3600);
}
// get a tags
if (isset($_POST['tags'])){
	$tags = array();
	$tags_str = $_POST['tags'];
	// print_r($tags_str);
	if (strlen($tags_str)>0){
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
}
if (isset($_POST['price'])){
	$price = $_POST['price'];
}else{
	$price = '100';
}
//send info to DB
$con = new db();
$val = 'true,true,"'.$size.'","'.$tag_id.'","'.href().'","'.$catagory.'","'.$comment.'","'.$price.'"';
// echo $val;
$con->dbcon->query('INSERT INTO `image` (px250,px1600,size,tag_id,href,folder,comment,price) VALUES ('.$val.')');
resizeHeight(100);
resizeWidth(1600);
//ssh send
function SSHSend(){
	if (isset($_POST['ssh'])){
		$ssh=new SSH();
		$ssh->SendFile($tmp_name,$_POST['newname']=$tmp_name,0744);
	}
}
//archiv to zip
function zip(){
	$first_name=$_POST['newname'];
	if (strlen($first_name)>0){
		$name=$first_name.'.jpg';
	}else{
		$name = basename($_FILES["image"]["name"]);
	}
	$type=$_FILES['image']['type'];
	$uploaddir = ROOT.'/uploads/';
	$imgdir = ROOT.'/img/';
	$tmp_name = $_FILES["image"]["tmp_name"];
	if (isset($_POST['zip'])){
		$zip = new ZipArchive();
		$new_name=substr($name, 0, -4);
		$zip_folder = $uploaddir."zip";
		if (file_exists($zip_folder)){
			$zip_name = $zip_folder.'/'.$new_name.".zip";
			if (!file_exists($zip_name)){
				if ($zip->open($zip_name, ZipArchive::CREATE)!==TRUE) {
					exit("<br>Невозможно открыть архив <$zip_name>\n");
				}
				if ($zip->open($zip_name, ZipArchive::CREATE) === TRUE) {
					// $zip->setPassword(substr($tmp_name,4,1000));
					$zip->addFile($tmp_name, $name);
					// $zip->setEncryptionName($$tmp_name, ZipArchive::EM_AES_256);
					$zip->close();
					echo '<br>Архив создан';
				} else {
				    echo '<br>Ошибка создания архива';
				}
				unset($zip);
			}else{
				echo '<br>Архивный файл с таким именем уже есть';
			}
		}else{
			mkdir($zip_folder, 0775, true);
			$zip_name = $zip_folder.'/'.$new_name.".zip";
			if ($zip->open($zip_name, ZipArchive::CREATE)!==TRUE) {
				exit("<br>Невозможно открыть архив <$zip_name>\n");
			}
			if ($zip->open($zip_name, ZipArchive::CREATE) === TRUE) {
				// $zip->setPassword(substr($tmp_name,4,1000));
				$zip->addFile($tmp_name, $name);
				// $zip->setEncryptionName($$tmp_name, ZipArchive::EM_AES_256);
				$zip->close();
				echo '<br>Архив создан';
			} else {
			    echo '<br>Ошибка создания архива';
			}
			unset($zip);
		}

	}
	// $fp = fopen('/home/uniquesite/uniquesite.ru/docs/dvor/data.pass', 'a+');
	// fwrite($fp, 'file:'.$name.';pass:'.substr($tmp_name,4,1000).'::::;');
	// fclose($fp);
	return "<br>Zip is OK";
}
//resize pictures
function resizeWidth($size){

	$type=$_FILES['image']['type'];
	$uploaddir = ROOT.'/uploads/';
	$tmp_name = $_FILES["image"]["tmp_name"];
	$image = new SimpleImage();
	$image->load($tmp_name);
	$image->resizeToWidth($size);
	$structure=$uploaddir.'1600/';
	// echo $structure;
	if (file_exists($structure)){
		if(!file_exists($structure.href())){
			$image->save($structure.href());
			// echo "<br>".$size."px образец создан";
			unset($image);
		}else{
			echo '<br>Есть файл с таким именем в категории '.$size;
		}

	}else{
		if (!mkdir($structure, 0755, true)) {
	    die('<br>Не удалось создать директорю.');
		}else{
			$image->save($structure.href());
			// echo "<br>".$size."px образец создан";
			unset($image);
		}
	}
}
function resizeHeight($size){

	$type=$_FILES['image']['type'];
	$uploaddir = ROOT.'/uploads/';
	$tmp_name = $_FILES["image"]["tmp_name"];
	$image = new SimpleImage();
	$image->load($tmp_name);
	$image->resizeToHeight($size);
	$structure=$uploaddir.'250/';
	// echo $structure;
	if (file_exists($structure)){
		if(!file_exists($structure.href())){
			$image->save($structure.href());
			// echo "<br>".$size."px образец создан";
			unset($image);
		}else{
			echo '<br>Есть файл с таким именем в категории '.$size;
		}

	}else{
		if (!mkdir($structure, 0755, true)) {
	    die('<br>Не удалось создать директорю.');
		}else{
			$image->save($structure.href());
			// echo "<br>".$size."px образец создан";
			unset($image);
		}
	}
}
// move_uploaded_file($tmp_name, "$uploaddir/original/$name");
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
