<?php
session_start();
error_reporting( E_ALL );
?>
<!DOCTYPE html>
<html lang="ru">
<script src='/admin/js/base64.js'></script>
<?php
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
$url = $_SERVER['REQUEST_URI'];
require(ROOT."/admin/head.php");
?>
<body>

<?php
	if ( (isset($_COOKIE['firstname'])) & (isset($_COOKIE['nickname'])) & (isset($_COOKIE['pass'])) ){
		if ($_COOKIE['pass']=='ok'){
			require ROOT."/admin/header.php";
				if ($url =="/admin/"){
					require ROOT."/admin/settings.php";
				}
				if(isset($_GET['page'])){
					if ($_GET['page']=="add_image"){
						require ROOT."/admin/add_image.php";
					}
					if ($_GET['page']=="editimage"){
						require ROOT."/admin/editimage.php";
					}
					if ($_GET['page']=="cat"){
						require ROOT."/admin/editimage.php";
					}
					if ($_GET['page']=="all"){
						require ROOT."/admin/all.php";
					}
					if ($_GET['page']=="users"){
						require ROOT."/admin/users.php";
					}
					if ($_GET['page']=="tags"){
						require ROOT."/admin/tags.php";
					}
					if ($_GET['page']=="orders"){
						require ROOT."/admin/orders.php";
					}
					if ($_GET['page']=="exit"){
						unset($_COOKIE['firstname']);
						unset($_COOKIE['nickname']);
						unset($_COOKIE['pass']);
						setcookie("firstname", null, -1, "/admin");
						setcookie("nickname", null, -1, "/admin" );
						setcookie("pass", null, -1, "/admin" );
						session_destroy();
						header("Location: http://xn--80aakfqalcwe5ayf2d3c.xn--p1ai/");
						exit();
					}

				}
			// print_r($_SERVER);
		}else{
			require ROOT.'/admin/login.php';
		}

	}else{
		require ROOT.'/admin/login.php';
	}
?>

</body>
</html>
