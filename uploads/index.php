<?php
header('HTTP/1.0 404 Not Found', true, 404);
die();

//if you want to uplads meny files put in file.txt and delete comment and upper text comment

// define('ROOT', $_SERVER['DOCUMENT_ROOT']);
// require ROOT. '/function/class.db.php';
// $con = new db();
// $filename = ROOT.'/uploads/file.txt';
// $file = file($filename);
// $cou = count($file);
// echo $cou."<br><hr>";
// unset($file[$cou]);
// foreach ($file as $key => $value) {
//   $val = 'true,true,"2000x680","'.$value.'","1",""';
//   $sql = 'INSERT INTO `image` (px250,px1600,size,href,folder,comment) VALUES ('.$val.');';
//   echo $sql;
//   $con->dbcon->query($sql);
// }

// comment to this line
