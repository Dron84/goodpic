<?
define('doc_root',$_SERVER['DOCUMENT_ROOT']);
include(doc_root.'/function/ls.php');
// print_r( ls("*",doc_root.'/uploads/w1600/') );
$where=$_GET['where'];
$var=ls("*", doc_root.'/uploads/'.$where);
foreach ($var as $key => $value) {
	if ($value=='index.php'){
		unset($var[$key]);
	}
}
// $str = json_encode($var);
// <div class="col-xs-12 col-md-6">
// 	<img src="http://lorempixel.com/959/160/" class="img-thumbnail" alt="Cinque Terre">
// </div>