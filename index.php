<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<?php
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
include(ROOT."/head.php");
?>
<body>
	<?php include(ROOT."/header.php"); ?>
	<section>


				<?php
				if (isset($_GET['page'])){
					if( ($_GET['page']!='price') & ($_GET['page']!='info') & ($_GET['page']!='cart') & ($_GET['page']!='skinali') & ($_GET['page']!='freski')){
						require ROOT.'/load.php';
					}elseif($_GET['page']=='price'){
						require ROOT.'/price.php';
					}elseif($_GET['page']=='info'){
						require ROOT.'/info.php';
					}elseif($_GET['page']=='cart'){
						require ROOT.'/cart.php';
					}elseif($_GET['page']=='skinali'){
						require ROOT.'/skinali.php';
					}elseif($_GET['page']=='freski'){
						require ROOT.'/freski.php';
					}

				}elseif(empty($_GET['page'])){
					require(ROOT.'/function/class.db.php');
					require ROOT.'/main.php';
				}


				?>


	</section>
</body>
</html>
