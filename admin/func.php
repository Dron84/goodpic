<?php
	define('ROOT', $_SERVER['DOCUMENT_ROOT']);
	require ROOT.'/function/class.db.php';
	if (isset($_POST['catname'])){
			if ($_POST['addcat']=='1'){
				$catname = $_POST['catname'];
				$con = new db();
				$con->insert('category','catname',$catname);
				Header("HTTP/1.0 200 OK");
			}
		}
	if (isset($_POST['loadcatname'])){
		if ($_POST['loadcatname']=="1"){
			$con = new db();
			if ($result = $con->dbcon->query('select * from `category`;')) {
			    /* извлечение ассоциативного массива */
					print_r($result);
					// while ($row = $result->fetch_assoc()) {
					// 	echo "<option value=".$row['id'].">".base64_decode($row['catname'])."</option>";
					// }
			    /* удаление выборки */
			    $result->free();
			}
		}
	}
	if ( (isset($_POST['submit'])) && (isset($_POST['user'])) && (isset($_POST['pass'])) ){
			$user = strtolower($_POST['user']);
			$pass = base64_encode($_POST['pass']);
			$con = new db();
			// SELECT * FROM `user` WHERE nickname = "dron" and pass = "MTIz";
			$str = 'SELECT * FROM `user` WHERE nickname = "'.$user.'" AND pass = "'.$pass.'";';
			//echo $str;
			if ($result = $con->dbcon->query($str)) {
					//print_r($result);
					/* извлечение ассоциативного массива */
					if ($row = $result->fetch_assoc()) {\
						//print_r($row);
						setcookie("firstname", $row['firstname'], time()+3600);
						setcookie("nickname", $row['nickname'], time()+3600);
						setcookie("pass", 'ok', time()+3600);
						header('Location: /admin/');
					} else {
						header('Location: ' . $_SERVER['HTTP_REFERER'].'?error=baduser');
					}
			    /* удаление выборки */
			    $result->free();
			}
		}
	if (isset($_POST['db_config'])){
			if ($_POST['db_config']==true){
				$file =json_encode($_POST);
				file_put_contents(ROOT.'/admin/config.json', $file );
				echo 'OK';
			}else{
				echo "ERROR";
			}
		}

	function categoryLoadFromDB($tag_name_to, $typeValue){
		$con = new db();
		if ($result = $con->dbcon->query("select * from `category` WHERE tagid=0 or tagid=-1;")) {
			$result = $result->fetch_all();
			for ($i=0; $i < count($result) ; $i++) {
				 $row = $result[$i];
				 if ($row[2]=='-1'){
					 // $conresult[$i]= array('value' => $row[0], 'catname'=> base64_decode($row[1]));
					 echo "<".$tag_name_to." ".$typeValue."='".$row[0]."'>".base64_decode($row[1])."</".$tag_name_to.">";
					 $str = "select * from `category` WHERE tagid=".$row[0].";";
					 if ($result2 = $con->dbcon->query($str)){
						 while ($row2 = $result2->fetch_assoc()) {
							 	// $conresult[$i]['podcat'][]= array('value' => $row2['id'], 'catname'=> base64_decode($row2['catname']));
								echo "<".$tag_name_to." ".$typeValue."='".$row2['id']."'>&nbsp&nbsp&nbsp".base64_decode($row2['catname'])."</".$tag_name_to.">";
							 }
					 }
				 }else if($row[2]=='0'){
					 // $conresult[$i]= array('value' => $row[0], 'catname'=> base64_decode($row[1]));
					 echo "<".$tag_name_to." ".$typeValue."='".$row[0]."'>".base64_decode($row[1])."</".$tag_name_to.">";
				 }
			}
		}
		// return $conresult;
	}
	function cloudOfTags(){
		$con = new db();
		if ($result = $con->dbcon->query('select * from `tags`;')) {
			while ($row = $result->fetch_assoc()) {
				echo "#<tag class='tags'>".base64_decode($row['tagname'])." </tag>";
			}
		}
	}
?>
