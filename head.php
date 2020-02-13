<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		if (file_exists("seo.json") ){
			$json = file_get_contents("seo.json");
			$obj = json_decode($json,true);
		}else{
			$obj['description']='Описание';
			$obj['keywords']='Ключевые слова';
			$obj['title']=$_SERVER['SERVER_NAME'];
		}
	//print_r($obj)
	?>
	<meta name="description" content="<?php echo $obj['description'];?>" />
	<meta name="keywords" content="<?php echo $obj['keywords'];?>" />
	<meta name="author" content="uniquesite.ru">
	<title><?php echo $obj['title'];?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

	<script src='/js/jquery.trplclick.min.js'></script>
	<script src='/js/jquery.cookie.min.js'></script>
	<script src='/js/script.js'></script>
	<link rel="stylesheet" href="/css/index.css">
	<link rel='icon' href='/img/logo.jpg' sizes="any" type="image/jpeg">
	<link rel="shortcut icon" href="/img/logo.jpg" type="image/jpeg">
</head>
