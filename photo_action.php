<?php 
	if (!isset($_SESSION['user_id']))
		require "authorization.php";
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title> Регистрация.</title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>

<div id="content">
<?php
	$user_id = $_SESSION['user_id'];

	include("config.php");
	$err = array();	
	$img_up = 1; 	//флаг загрузки фото
	$reg_action=1;  // флаг успешно ли прошла проедура загрузки

		if (!($_FILES['up_file']['size']>0)) {
			$err[] = "нет фото";
		}
		$res = mysql_query("select * from `killer` where `id`='$user_id'", $con) or die ("Error! query – запрос записи в таблице игроков");
		$arr = mysql_fetch_array($res, MYSQL_NUM);
		include("resize_crop.php");
		$path = "img/users/";
		$types = array('image/gif', 'image/png', 'image/jpeg');
		$name_file = "";
		$uploadfile = "";
	
	if(($_FILES['up_file']['size']>0) and ($_FILES['up_file']['size']< 2.5*1024*1024)){
			if (!in_array($_FILES['up_file']['type'], $types)){
				$err[] = "запрещённый тип файла";
			} else {
				$info = new SplFileInfo($_FILES['up_file']['name']);
				$apend="photo_$user_id.".$info->getExtension();
				$name_file = $apend;
				$uploadfile = "$path$apend";
				if (move_uploaded_file($_FILES['up_file']['tmp_name'], $uploadfile)) {
					$size = GetImageSize($uploadfile);
					
					if (($size[0] < 600) or ($size[1]<600)){
						$err[] = "фотография меньше, чем 600х600 px";
						$reg_action=0;
						$img_up = 1;
					}
					
					$width = $size[0];
					$height = $size[1];
					if ($width > $height){
						if ($width > 600 ) {
							//	$err[] = "ширина изображения больше 800px!";
							//unlink($uploadfile);
							$koef = 600/$width;
							resize($uploadfile, $uploadfile, 600, $size[1]*$koef);
							$img_up = 1;
						}
					} else {
						if ($height > 600 ) {
							//	$err[] = "ширина изображения больше 800px!";
							//unlink($uploadfile);
							$koef = 600/$height;
							resize($uploadfile, $uploadfile, $size[0]*$koef, 600);
							$img_up = 1;
						}
					}						
				} else {
					$err[] = "не удалось загрузить фотографию";
					$reg_action=0;
					$img_up = 0;
				}
			}
	} else {
		$err[] = "размер картинки больше 2.5 Мб";
		$reg_action=0;
		$img_up = 0;
	}
?>
	<h1><?php 
	if($reg_action) { echo"Вы сделали это!"; 
//		$res = mysql_query("select * from `killer` where `id` = '$user_id' ", $con) or die ("Error! query – запрос строки киллера");
//		$arr = mysql_fetch_array($res, MYSQL_NUM);
//		unlink($path.$arr[10]);
		mysql_query("update `killer` set `status_photo` = '1',`name_photo`='$name_file', `message`='' where `id` = '$user_id' ") or die ("Error! query – write DB");
//		echo "Всё нормально. Деньги есть!";

	} 
	else  {echo "ПРИ ЗАГРУЗКЕ ФОТО ПРОИЗОШЛИ ОШИБКИ:";
		if ($img_up) unlink($uploadfile);
	}
	?></h1>
<div class="errors">
<ul><?php
	if($reg_action) echo "<script> var reg=1; </script>";
	else {
		echo "<script> var reg=0; </script>";
		foreach($err AS $error) {
			?> <li><?php echo " $error";
		} ?></li></div><div align="right"><?php
		echo "<br><a href=\"game_registration.php\"> Загрузить новое фото!</a>";
	}
?></ul>
	
	<script>
		var delay = 3000;
		if (reg){
			setTimeout("document.location.href='game_registration.php'", delay);
		}
	</script>
</div>
</div>

</body>
</html>