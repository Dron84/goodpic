<?php
if  (isset($_POST['order']))
	{
	define('ROOT', $_SERVER['DOCUMENT_ROOT']);
	$file = file_get_contents(ROOT."/admin/config.json");
	$json_config = json_decode($file, true);
	if(isset($_POST['email'])){
		$email = $_POST['email'];
	}else{
		$email="email не указан";
	}
	$order = $_POST['order'];
	if (isset($_POST['phone'])){
		$phone = $_POST['phone'];
	}else{
		$phone="телефон не указан";
	}

	require(ROOT.'/function/class.db.php');
	$con = new db();
	if ($order == "1")
	{
		$to = strtolower($json_config['sendmail_to']); // обратите внимание на запятую
		// echo '$to='.$to;
		// $to = 'dron84@gmail.com';
		// тема письма
		$subject = 'Новая заявка';
		// echo '$subject='.$subject;
		// текст письма
		$message = '
		<html>
		<head>
			<title>Новая заявка</title>
		</head>
		<body>
			Пользователь с почтой <i>'.$email.'</i> и телефоном <i>'.$phone.'</i>.<br>
			Хочет что бы вы с ним связались
			<a href=mailto:'.$email.'>Написать письмо</a>
			если с телефона то можно позвонить
			<a href=tel:'.$phone.'>Позвонить</a>
			<table class="table table-bordered" >
	    <thead>
	      <tr>
	        <th>ID</th>
	        <th>Имя файла</th>
	        <th>Размеры</th>
	        <th>Цена</th>
	      </tr>
	    </thead>
	    <tbody>';

	      if (isset($_COOKIE['cart'])){

	        $str = $_COOKIE['cart'];
	        $cart_exp = explode("::", $str);
	        //print_r($cart_exp);
	        $cou = count($cart_exp)-1;
	        //echo $cou;
	        $id ='';
	        for ($i=0; $i < $cou; $i++) {
	          if ($i == ($cou-1)){
	            $id .='id='.$cart_exp[$i];
	          }else{
	            $id .='id='.$cart_exp[$i].' OR ';
	          }
	        }
	        $sql = 'SELECT * FROM `image` WHERE '.$id;
	        //echo $sql;
	        if ($result = $con->dbcon->query($sql)){
	          while($row = $result->fetch_assoc()){
	            $message .="<tr>
				                    <td>".$row['id']."</td>
				                    <td>".$row['href']."</td>
				                    <td>".$row['size']."</td>
				                    <td>100</td>
				                  </tr>";
	          }
	        }
	      }

	$message .='</tbody>
						  </table>
							</body>
							</html>';

		// Для отправки HTML-письма должен быть установлен заголовок Content-type
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		// Дополнительные заголовки
		// $headers .= 'To: Mary <mary@example.com>';
		//sendmail_from
		if (isset($json_config['sendmail_from'])){
			$headers .= 'From: '.$json_config['sendmail_from'];
		}else{
			$headers .= 'From: <_des_08@mail.ru>';
		}
		// $headers[] = 'Cc: birthdayarchive@example.com';
		// $headers[] = 'Bcc: birthdaycheck@example.com';
		// Отправляем
		// echo $headers;
		// echo $message;
		// var_dump(mail($to, $subject, $message, $headers));
		if(mail($to, $subject, $message, $headers)){
			$sql2 = 'INSERT INTO `orders` (email,tel,order_str,status_order) VALUES ("'.base64_encode($email).'","'.base64_encode($phone).'","'.$_COOKIE['cart'].'","'.base64_encode('в обработке').'");';
			// echo $sql2;
			if ($con->dbcon->query($sql2)){
				unset($_COOKIE['cart']);
				echo "OK";
			}
		}else{
			echo "Не могу отправить письмо";
		}


	}
}else{
	http_response_code(404);
	require '/404.php'; // provide your own HTML for the error page
	die();
}

?>
